<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250514105555 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE customer (id BIGINT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, is_active TINYINT(1) DEFAULT 0 NOT NULL, delivery_address_id INT DEFAULT NULL, invoice_address_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_81398E09E7927C74 (email), INDEX IDX_81398E09EBF23851 (delivery_address_id), INDEX IDX_81398E09C6BDFEB (invoice_address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE delivery_address (id INT AUTO_INCREMENT NOT NULL, delivery_instructions LONGTEXT DEFAULT NULL, address_street VARCHAR(255) NOT NULL, address_city VARCHAR(255) NOT NULL, address_postal_code VARCHAR(100) NOT NULL, address_phone_number VARCHAR(25) NOT NULL, address_created_at DATETIME NOT NULL, address_updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE invoice_address (id INT AUTO_INCREMENT NOT NULL, company_tax_id VARCHAR(255) DEFAULT NULL, company_name VARCHAR(255) DEFAULT NULL, address_street VARCHAR(255) NOT NULL, address_city VARCHAR(255) NOT NULL, address_postal_code VARCHAR(100) NOT NULL, address_phone_number VARCHAR(25) NOT NULL, address_created_at DATETIME NOT NULL, address_updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09EBF23851 FOREIGN KEY (delivery_address_id) REFERENCES delivery_address (id)');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E09C6BDFEB FOREIGN KEY (invoice_address_id) REFERENCES invoice_address (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09EBF23851');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E09C6BDFEB');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE delivery_address');
        $this->addSql('DROP TABLE invoice_address');
    }
}
