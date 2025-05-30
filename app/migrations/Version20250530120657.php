<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250530120657 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE delivery_address DROP INDEX IDX_750D05FF5B7AF75, ADD UNIQUE INDEX UNIQ_750D05FF5B7AF75 (address_id)');
        $this->addSql('ALTER TABLE delivery_address DROP FOREIGN KEY FK_750D05FF5B7AF75');
        $this->addSql('ALTER TABLE delivery_address ADD CONSTRAINT FK_750D05FF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE invoice_address DROP INDEX IDX_FF975952F5B7AF75, ADD UNIQUE INDEX UNIQ_FF975952F5B7AF75 (address_id)');
        $this->addSql('ALTER TABLE invoice_address DROP FOREIGN KEY FK_FF975952F5B7AF75');
        $this->addSql('ALTER TABLE invoice_address ADD CONSTRAINT FK_FF975952F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice_address DROP INDEX UNIQ_FF975952F5B7AF75, ADD INDEX IDX_FF975952F5B7AF75 (address_id)');
        $this->addSql('ALTER TABLE invoice_address DROP FOREIGN KEY FK_FF975952F5B7AF75');
        $this->addSql('ALTER TABLE invoice_address ADD CONSTRAINT FK_FF975952F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE delivery_address DROP INDEX UNIQ_750D05FF5B7AF75, ADD INDEX IDX_750D05FF5B7AF75 (address_id)');
        $this->addSql('ALTER TABLE delivery_address DROP FOREIGN KEY FK_750D05FF5B7AF75');
        $this->addSql('ALTER TABLE delivery_address ADD CONSTRAINT FK_750D05FF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
    }
}
