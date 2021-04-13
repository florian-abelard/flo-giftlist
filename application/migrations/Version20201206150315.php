<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201206150315 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE gift ADD event_id UUID DEFAULT NULL');
        $this->addSql('ALTER TABLE gift ADD note VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE gift ADD gift_date DATE DEFAULT NULL');
        $this->addSql('COMMENT ON COLUMN gift.event_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE gift ADD CONSTRAINT FK_A47C990D71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_A47C990D71F7E88B ON gift (event_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE gift DROP CONSTRAINT FK_A47C990D71F7E88B');
        $this->addSql('DROP INDEX IDX_A47C990D71F7E88B');
        $this->addSql('ALTER TABLE gift DROP event_id');
        $this->addSql('ALTER TABLE gift DROP note');
        $this->addSql('ALTER TABLE gift DROP gift_date');
    }
}
