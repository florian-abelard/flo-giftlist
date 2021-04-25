<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210223180651 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE gift DROP CONSTRAINT fk_a47c990d401b253c');
        $this->addSql('DROP TABLE event_type');
        $this->addSql('ALTER TABLE idea ADD event_date DATE DEFAULT NULL');
        $this->addSql('DROP INDEX idx_a47c990d401b253c');
        $this->addSql('ALTER TABLE gift ADD event_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE gift DROP event_type_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE event_type (id UUID NOT NULL, code VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, sorting INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN event_type.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE idea DROP event_date');
        $this->addSql('ALTER TABLE gift ADD event_type_id UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE gift DROP event_date');
        $this->addSql('COMMENT ON COLUMN gift.event_type_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE gift ADD CONSTRAINT fk_a47c990d401b253c FOREIGN KEY (event_type_id) REFERENCES event_type (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_a47c990d401b253c ON gift (event_type_id)');
    }
}
