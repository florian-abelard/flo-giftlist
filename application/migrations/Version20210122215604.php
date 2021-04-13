<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210122215604 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE gift DROP CONSTRAINT fk_a47c990d71f7e88b');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP INDEX idx_a47c990d71f7e88b');
        $this->addSql('ALTER TABLE gift RENAME COLUMN event_id TO event_type_id');
        $this->addSql('ALTER TABLE gift RENAME COLUMN gift_date TO date');
        $this->addSql('ALTER TABLE gift ADD CONSTRAINT FK_A47C990D401B253C FOREIGN KEY (event_type_id) REFERENCES event_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_A47C990D401B253C ON gift (event_type_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE event (id UUID NOT NULL, type_id UUID DEFAULT NULL, label VARCHAR(255) NOT NULL, year INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_3bae0aa7c54c8c93 ON event (type_id)');
        $this->addSql('COMMENT ON COLUMN event.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN event.type_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT fk_3bae0aa7c54c8c93 FOREIGN KEY (type_id) REFERENCES event_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE gift DROP CONSTRAINT FK_A47C990D401B253C');
        $this->addSql('DROP INDEX IDX_A47C990D401B253C');
        $this->addSql('ALTER TABLE gift RENAME COLUMN event_type_id TO event_id');
        $this->addSql('ALTER TABLE gift RENAME COLUMN date TO gift_date');
        $this->addSql('ALTER TABLE gift ADD CONSTRAINT fk_a47c990d71f7e88b FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_a47c990d71f7e88b ON gift (event_id)');
    }
}
