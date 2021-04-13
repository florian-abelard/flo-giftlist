<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210223182936 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE idea ALTER event_date TYPE VARCHAR(4)');
        $this->addSql('ALTER TABLE idea ALTER event_date DROP DEFAULT');
        $this->addSql('ALTER TABLE gift ALTER event_date TYPE VARCHAR(4)');
        $this->addSql('ALTER TABLE gift ALTER event_date DROP DEFAULT');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE idea ALTER event_date TYPE DATE');
        $this->addSql('ALTER TABLE idea ALTER event_date DROP DEFAULT');
        $this->addSql('ALTER TABLE idea ALTER event_date TYPE DATE');
        $this->addSql('ALTER TABLE gift ALTER event_date TYPE DATE');
        $this->addSql('ALTER TABLE gift ALTER event_date DROP DEFAULT');
        $this->addSql('ALTER TABLE gift ALTER event_date TYPE DATE');
    }
}
