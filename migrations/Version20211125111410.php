<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Component\Uid\Uuid;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211125111410 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE lol_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE lol (id INT NOT NULL, lol_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_18EDB14D3D66DA87 ON lol (lol_id)');
        $this->addSql('COMMENT ON COLUMN lol.lol_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE space (id UUID NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2972C13A5E237E06 ON space (name)');
        $this->addSql('COMMENT ON COLUMN space.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE variable (id UUID NOT NULL, space_id UUID NOT NULL, key VARCHAR(255) NOT NULL, value VARCHAR(2048) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_CC4D878D23575340 ON variable (space_id)');
        $this->addSql('CREATE INDEX IDX_CC4D878D8A90ABA9 ON variable (key)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CC4D878D235753408A90ABA9 ON variable (space_id, key)');
        $this->addSql('COMMENT ON COLUMN variable.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN variable.space_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE lol ADD CONSTRAINT FK_18EDB14D3D66DA87 FOREIGN KEY (lol_id) REFERENCES space (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE variable ADD CONSTRAINT FK_CC4D878D23575340 FOREIGN KEY (space_id) REFERENCES space (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql("INSERT INTO space (id, name) VALUES ('" . Uuid::v4() . "','default')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE lol DROP CONSTRAINT FK_18EDB14D3D66DA87');
        $this->addSql('ALTER TABLE variable DROP CONSTRAINT FK_CC4D878D23575340');
        $this->addSql('DROP SEQUENCE lol_id_seq CASCADE');
        $this->addSql('DROP TABLE lol');
        $this->addSql('DROP TABLE space');
        $this->addSql('DROP TABLE variable');
    }
}
