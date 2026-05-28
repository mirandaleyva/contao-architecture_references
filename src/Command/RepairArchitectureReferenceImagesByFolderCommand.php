<?php

declare(strict_types=1);

namespace MirandaLeyva\ContaoArchitectureReferences\Command;

use MirandaLeyva\ContaoArchitectureReferences\Service\ArchitectureReferenceImageFolderRepairService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
  name: 'architecture-references:repair-images-by-folder',
  description: 'Repairs project images by matching legacy project titles with current folders in tl_files.'
)]
class RepairArchitectureReferenceImagesByFolderCommand extends Command
{
  public function __construct(
    private readonly ArchitectureReferenceImageFolderRepairService $repairService,
  ) {
    parent::__construct();
  }

  protected function configure(): void
  {
    $this->addOption(
      'apply',
      null,
      InputOption::VALUE_NONE,
      'Write changes to the database. Without this option, only a dry run is executed.'
    );
  }

  protected function execute(InputInterface $input, OutputInterface $output): int
  {
    $apply = (bool) $input->getOption('apply');

    $report = $this->repairService->repair(!$apply);

    $output->writeln($apply ? 'Image repair applied.' : 'Dry run finished. No changes were written.');
    $output->writeln('');
    $output->writeln('Checked projects: ' . $report['checked']);
    $output->writeln('Updated projects: ' . $report['updated']);
    $output->writeln('Missing target projects: ' . count($report['missingTargetProjects']));
    $output->writeln('Missing folders: ' . count($report['missingFolders']));
    $output->writeln('Missing images: ' . count($report['missingImages']));
    $output->writeln('Ambiguous folders: ' . count($report['ambiguousFolders']));

    if (!empty($report['missingFolders'])) {
      $output->writeln('');
      $output->writeln('Missing folders:');

      foreach (array_slice($report['missingFolders'], 0, 30) as $item) {
        $output->writeln('- ' . $item['project'] . ' [' . $item['target_alias'] . ']');
      }
    }

    if (!empty($report['ambiguousFolders'])) {
      $output->writeln('');
      $output->writeln('Ambiguous folders:');

      foreach (array_slice($report['ambiguousFolders'], 0, 10) as $item) {
        $output->writeln('- ' . $item['project'] . ': ' . implode(', ', $item['folders']));
      }
    }

    return Command::SUCCESS;
  }
}
