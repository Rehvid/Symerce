<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250530024743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, street VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, postal_code VARCHAR(100) NOT NULL, country_id BIGINT NOT NULL, INDEX IDX_D4E6F81F92F3E70 (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE contact_details (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, phone VARCHAR(25) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE customer ADD contact_details_id INT DEFAULT NULL, DROP firstname, DROP surname, DROP phone');
        $this->addSql('ALTER TABLE customer ADD CONSTRAINT FK_81398E097CA35EB5 FOREIGN KEY (contact_details_id) REFERENCES contact_details (id)');
        $this->addSql('CREATE INDEX IDX_81398E097CA35EB5 ON customer (contact_details_id)');
        $this->addSql('ALTER TABLE delivery_address ADD address_id INT NOT NULL, DROP postal_code, DROP street, DROP city, DROP country');
        $this->addSql('ALTER TABLE delivery_address ADD CONSTRAINT FK_750D05FF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('CREATE INDEX IDX_750D05FF5B7AF75 ON delivery_address (address_id)');
        $this->addSql('ALTER TABLE invoice_address ADD address_id INT NOT NULL, DROP postal_code, DROP street, DROP city, DROP country');
        $this->addSql('ALTER TABLE invoice_address ADD CONSTRAINT FK_FF975952F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('CREATE INDEX IDX_FF975952F5B7AF75 ON invoice_address (address_id)');
        $this->addSql('DROP INDEX UNIQ_E52FFDEEE7927C74 ON orders');
        $this->addSql('ALTER TABLE orders ADD contact_details_id INT NOT NULL, DROP email, DROP phone, DROP firstname, DROP surname');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE7CA35EB5 FOREIGN KEY (contact_details_id) REFERENCES invoice_address (id)');
        $this->addSql('CREATE INDEX IDX_E52FFDEE7CA35EB5 ON orders (contact_details_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F81F92F3E70');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE contact_details');
        $this->addSql('ALTER TABLE invoice_address DROP FOREIGN KEY FK_FF975952F5B7AF75');
        $this->addSql('DROP INDEX IDX_FF975952F5B7AF75 ON invoice_address');
        $this->addSql('ALTER TABLE invoice_address ADD postal_code VARCHAR(100) NOT NULL, ADD street VARCHAR(255) NOT NULL, ADD city VARCHAR(255) NOT NULL, ADD country VARCHAR(100) NOT NULL, DROP address_id');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE7CA35EB5');
        $this->addSql('DROP INDEX IDX_E52FFDEE7CA35EB5 ON orders');
        $this->addSql('ALTER TABLE orders ADD email VARCHAR(255) NOT NULL, ADD phone VARCHAR(25) NOT NULL, ADD firstname VARCHAR(255) NOT NULL, ADD surname VARCHAR(255) NOT NULL, DROP contact_details_id');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E52FFDEEE7927C74 ON orders (email)');
        $this->addSql('ALTER TABLE customer DROP FOREIGN KEY FK_81398E097CA35EB5');
        $this->addSql('DROP INDEX IDX_81398E097CA35EB5 ON customer');
        $this->addSql('ALTER TABLE customer ADD firstname VARCHAR(255) NOT NULL, ADD surname VARCHAR(255) NOT NULL, ADD phone VARCHAR(25) NOT NULL, DROP contact_details_id');
        $this->addSql('ALTER TABLE delivery_address DROP FOREIGN KEY FK_750D05FF5B7AF75');
        $this->addSql('DROP INDEX IDX_750D05FF5B7AF75 ON delivery_address');
        $this->addSql('ALTER TABLE delivery_address ADD postal_code VARCHAR(100) NOT NULL, ADD street VARCHAR(255) NOT NULL, ADD city VARCHAR(255) NOT NULL, ADD country VARCHAR(100) NOT NULL, DROP address_id');
    }
}
