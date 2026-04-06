<?php

namespace MirandaLeyva\ContaoArchitectureReferences\Command;

use MirandaLeyva\ContaoArchitectureReferences\Service\ArchitectureReferencesMigrationService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:migrate-architecture-references',
    description: 'Migrates legacy architecture references data.'
)]
class MigrateArchitectureReferencesCommand extends Command
{
    public function __construct(
        private readonly ArchitectureReferencesMigrationService $migrationService
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->migrationService->migrate();

        $output->writeln('Migration completed.');

        return Command::SUCCESS;
    }
}