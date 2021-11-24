<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211124213136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE space (id UUID NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2972C13A5E237E06 ON space (name)');
        $this->addSql('COMMENT ON COLUMN space.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE variable (id UUID NOT NULL, group_id VARCHAR(255) DEFAULT NULL, key VARCHAR(255) NOT NULL, value VARCHAR(2048) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CC4D878D8A90ABA9 ON variable (key)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CC4D878DFE54D9478A90ABA9 ON variable (group_id, key)');
        $this->addSql('COMMENT ON COLUMN variable.id IS \'(DC2Type:uuid)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE space');
        $this->addSql('DROP TABLE variable');
    }
}
