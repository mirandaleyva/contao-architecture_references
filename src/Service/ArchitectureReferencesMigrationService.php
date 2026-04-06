<?php

namespace MirandaLeyva\ContaoArchitectureReferences\Service;

use Doctrine\DBAL\Connection; // Connection Doctrine

class ArchitectureReferencesMigrationService
{
    public function __construct(
        private readonly Connection $connection,
        private readonly ArchitectureReferencesMapper $mapper,
    ) {
    }

    public function migrate(): void
    {
        $legacyRecords = $this->connection->fetchAllAssociative('SELECT * FROM tl_sds_projects'); // DB Connnection

        foreach ($legacyRecords as $legacyRecord) {
            $data = $this->mapper->mapLegacyRecord($legacyRecord);
            
            // Check if already exist
            $existing = $this->connection->fetchOne(
                'SELECT id FROM tl_architecture_references WHERE alias = ?',
                [$data['alias']]
            );

            if (!$existing) {
                $this->connection->insert('tl_architecture_references', $data);
            }
        }
    }
}