<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250530121925 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer DROP INDEX IDX_81398E09C6BDFEB, ADD UNIQUE INDEX UNIQ_81398E09C6BDFEB (invoice_address_id)');
        $this->addSql('ALTER TABLE customer DROP INDEX IDX_81398E09EBF23851, ADD UNIQUE INDEX UNIQ_81398E09EBF23851 (delivery_address_id)');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09C6BDFEB');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09EBF23851');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09C6BDFEB FOREIGN KEY (invoice_address_id) REFERENCES invoice_address (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09EBF23851 FOREIGN KEY (delivery_address_id) REFERENCES delivery_address (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer DROP INDEX UNIQ_81398E09EBF23851, ADD INDEX IDX_81398E09EBF23851 (delivery_address_id)');
        $this->addSql('ALTER TABLE customer DROP INDEX UNIQ_81398E09C6BDFEB, ADD INDEX IDX_81398E09C6BDFEB (invoice_address_id)');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09EBF23851');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09C6BDFEB');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09EBF23851 FOREIGN KEY (delivery_address_id) REFERENCES delivery_address (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09C6BDFEB FOREIGN KEY (invoice_address_id) REFERENCES invoice_address (id)');
    }
}
