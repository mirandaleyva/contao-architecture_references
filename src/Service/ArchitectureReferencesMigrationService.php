<?php

namespace MirandaLeyva\ContaoArchitectureReferences\Service;

use Doctrine\DBAL\Connection;

class ArchitectureReferencesMigrationService
{
    public function __construct(
        private readonly Connection $connection,
        private readonly ArchitectureReferencesMapper $mapper,
    ) {
    }

    public function migrate(): void
    {
        $legacyRecords = $this->connection->fetchAllAssociative('SELECT * FROM tl_sds_projects');

        foreach ($legacyRecords as $legacyRecord) {
            $data = $this->mapper->mapLegacyRecord($legacyRecord);

            $this->connection->insert('tl_architecture_references', $data);
        }
    }
}