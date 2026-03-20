<?php

namespace MirandaLeyva\ContaoArchitectureReferences\Service;

class ArchitectureReferencesMapper
{
    public function mapLegacyRecord(array $legacy): array
    {
        return [
            'title' => $legacy['title'] ?? '',
            'alias' => $legacy['alias'] ?? '',
            'category' => $legacy['category'] ?? '',
            'short_description' => $legacy['short_description'] ?? '',
            'long_description' => $legacy['long_descriptionA'] ?? '',
            'completion' => $legacy['completion'] ?? '',
            'location' => $legacy['location'] ?? '',
            'work' => $legacy['work'] ?? '',
            'status' => $legacy['status'] ?? '',
            'photographer' => $legacy['fotografer'] ?? '',
            'visualizer' => $legacy['visualising'] ?? '',
            'photographer_link' => $legacy['fotografer_link'] ?? '',
            'visualizer_link' => $legacy['visualising_link'] ?? '',
            'preview_image' => $legacy['preview_image'] ?? null,
            'gallery' => $legacy['gallery'] ?? null,
            'published' => $legacy['published'] ?? '0',
            'sorting' => (int) ($legacy['sortOrder'] ?? 0),
        ];
    }
}