<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbortMigrationException;
use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20160424220046 extends AbstractMigration
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

        $this->addSql('CREATE TABLE User (id CHAR(36) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO User (id) VALUES (\'78710367-e5e3-4e44-80fe-5cf885408d1e\')');
        $this->addSql('INSERT INTO User (id) VALUES (\'8d4f5ffd-257f-496f-a6da-6199ea38439c\')');
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

        $this->addSql('DROP TABLE User');
    }
}
