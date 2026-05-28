<?php

declare(strict_types=1);

namespace MirandaLeyva\ContaoArchitectureReferences\Service;

use Doctrine\DBAL\Connection;

class ArchitectureReferenceImageFolderRepairService
{
  public function __construct(
    private readonly Connection $connection,
  ) {}

  public function repair(bool $dryRun = true): array
  {
    $report = [
      'checked' => 0,
      'matched' => 0,
      'updated' => 0,
      'missingTargetProjects' => [],
      'missingFolders' => [],
      'missingImages' => [],
      'ambiguousFolders' => [],
    ];

    $legacyProjects = $this->connection->fetchAllAssociative(
      'SELECT * FROM tl_sds_projects'
    );

    foreach ($legacyProjects as $legacyProject) {
      $report['checked']++;

      $legacyId = (int) $legacyProject['id'];
      $legacyTitle = trim((string) ($legacyProject['title'] ?? ''));

      if ($legacyTitle === '') {
        continue;
      }

      $targetProject = $this->connection->fetchAssociative(
        'SELECT id, title, alias FROM tl_architecture_references WHERE alias LIKE ? OR title = ?',
        ['%-' . $legacyId, $legacyTitle]
      );

      if (!$targetProject) {
        $report['missingTargetProjects'][] = [
          'legacy_id' => $legacyId,
          'legacy_title' => $legacyTitle,
        ];
        continue;
      }

      $folder = $this->findBestFolder($legacyTitle);

      if ($folder === null) {
        $report['missingFolders'][] = [
          'project' => $legacyTitle,
          'target_alias' => $targetProject['alias'],
        ];
        continue;
      }

      if (is_array($folder)) {
        $report['ambiguousFolders'][] = [
          'project' => $legacyTitle,
          'folders' => $folder,
        ];
        continue;
      }

      $images = $this->findImagesInFolder($folder);

      if (empty($images)) {
        $report['missingImages'][] = [
          'project' => $legacyTitle,
          'folder' => $folder,
        ];
        continue;
      }

      $previewUuid = $images[0]['uuid'];
      $galleryUuids = array_column($images, 'uuid');

      $data = [
        'preview_image' => $previewUuid,
        'gallery' => serialize($galleryUuids),
        'tstamp' => time(),
      ];
      $report['matched']++;
      if (!$dryRun) {
        $this->connection->update(
          'tl_architecture_references',
          $data,
          ['id' => $targetProject['id']]
        );

        $report['updated']++;
      }
    }

    return $report;
  }

  private function findBestFolder(string $title): string|array|null
  {
    $candidates = $this->buildSearchTerms($title);

    foreach ($candidates as $term) {
      $folders = $this->connection->fetchFirstColumn(
        "SELECT path
                 FROM tl_files
                 WHERE type = 'folder'
                 AND REPLACE(path, '_', ' ') LIKE ?
                 ORDER BY path ASC",
        ['%' . $term . '%']
      );

      if (count($folders) === 1) {
        return $folders[0];
      }

      if (count($folders) > 1) {
        return $folders;
      }
    }

    return null;
  }

  private function findImagesInFolder(string $folder): array
  {
    return $this->connection->fetchAllAssociative(
      "SELECT uuid, path
             FROM tl_files
             WHERE type = 'file'
             AND path LIKE ?
             AND extension IN ('jpg', 'jpeg', 'png', 'webp')
             ORDER BY path ASC",
      [$folder . '/%']
    );
  }

  private function buildSearchTerms(string $title): array
  {
    $terms = [];

    $normalized = $this->normalize($title);

    $terms[] = $normalized;

    if (str_contains($normalized, '/')) {
      $terms[] = trim(explode('/', $normalized)[0]);
    }

    $terms[] = str_replace('str.', 'strasse', $normalized);
    $terms[] = str_replace('ä', 'ae', $normalized);
    $terms[] = str_replace('ö', 'oe', $normalized);
    $terms[] = str_replace('ü', 'ue', $normalized);

    $words = preg_split('/\s+/', $normalized);

    if ($words && count($words) >= 2) {
      $terms[] = implode(' ', array_slice($words, 0, 2));
      $terms[] = end($words);
    }

    return array_values(array_unique(array_filter($terms)));
  }

  private function normalize(string $value): string
  {
    $value = trim($value);
    $value = str_replace(['_', '-'], ' ', $value);
    $value = preg_replace('/\s+/', ' ', $value);

    return $value ?? '';
  }
}
