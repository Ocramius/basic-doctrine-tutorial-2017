<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbortMigrationException;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20160424223053 extends AbstractMigration
{
    /**
     * {@inheritDoc}
     *
     * @throws AbortMigrationException
     */
    public function up(Schema $schema)
    {
        $this->abortIf(
            'sqlite' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on "sqlite".'
        );

        $this->addSql('CREATE TABLE EnforcementRequest (id CHAR(36) NOT NULL, PRIMARY KEY(id))');
    }

    /**
     * {@inheritDoc}
     *
     * @throws AbortMigrationException
     */
    public function down(Schema $schema)
    {
        $this->abortIf(
            'sqlite' !== $this->connection->getDatabasePlatform()->getName(),
            'Migration can only be executed safely on "sqlite".'
        );

        $this->addSql('DROP TABLE EnforcementRequest');
    }
}
