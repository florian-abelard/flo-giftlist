<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200409201647 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE event (id UUID NOT NULL, label VARCHAR(255) NOT NULL, year INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN event.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE idea (id UUID NOT NULL, label VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN idea.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE ideas_recipients (idea_id UUID NOT NULL, recipient_id UUID NOT NULL, PRIMARY KEY(idea_id, recipient_id))');
        $this->addSql('CREATE INDEX IDX_54A62A475B6FEF7D ON ideas_recipients (idea_id)');
        $this->addSql('CREATE INDEX IDX_54A62A47E92F8F78 ON ideas_recipients (recipient_id)');
        $this->addSql('COMMENT ON COLUMN ideas_recipients.idea_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN ideas_recipients.recipient_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE "group" (id UUID NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "group".id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE gift (id UUID NOT NULL, label VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN gift.id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE recipient (id UUID NOT NULL, group_id UUID DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6804FB49FE54D947 ON recipient (group_id)');
        $this->addSql('COMMENT ON COLUMN recipient.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN recipient.group_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE ideas_recipients ADD CONSTRAINT FK_54A62A475B6FEF7D FOREIGN KEY (idea_id) REFERENCES idea (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ideas_recipients ADD CONSTRAINT FK_54A62A47E92F8F78 FOREIGN KEY (recipient_id) REFERENCES recipient (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE recipient ADD CONSTRAINT FK_6804FB49FE54D947 FOREIGN KEY (group_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE ideas_recipients DROP CONSTRAINT FK_54A62A475B6FEF7D');
        $this->addSql('ALTER TABLE recipient DROP CONSTRAINT FK_6804FB49FE54D947');
        $this->addSql('ALTER TABLE ideas_recipients DROP CONSTRAINT FK_54A62A47E92F8F78');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE idea');
        $this->addSql('DROP TABLE ideas_recipients');
        $this->addSql('DROP TABLE "group"');
        $this->addSql('DROP TABLE gift');
        $this->addSql('DROP TABLE recipient');
    }
}
