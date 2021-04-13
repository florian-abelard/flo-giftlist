<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201129180816 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE gifts_recipients (gift_id UUID NOT NULL, recipient_id UUID NOT NULL, PRIMARY KEY(gift_id, recipient_id))');
        $this->addSql('CREATE INDEX IDX_5D639EF297A95A83 ON gifts_recipients (gift_id)');
        $this->addSql('CREATE INDEX IDX_5D639EF2E92F8F78 ON gifts_recipients (recipient_id)');
        $this->addSql('COMMENT ON COLUMN gifts_recipients.gift_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN gifts_recipients.recipient_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE gifts_recipients ADD CONSTRAINT FK_5D639EF297A95A83 FOREIGN KEY (gift_id) REFERENCES gift (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE gifts_recipients ADD CONSTRAINT FK_5D639EF2E92F8F78 FOREIGN KEY (recipient_id) REFERENCES recipient (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE gift ADD price_value DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE gifts_recipients');
        $this->addSql('ALTER TABLE gift DROP price_value');
    }
}
