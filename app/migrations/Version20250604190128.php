<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250604190128 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attribute CHANGE position position INT DEFAULT 999 NOT NULL, CHANGE is_active is_active TINYINT(1) DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE attribute_value CHANGE position position INT DEFAULT 999 NOT NULL');
        $this->addSql('ALTER TABLE brand CHANGE is_active is_active TINYINT(1) DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE carrier CHANGE is_active is_active TINYINT(1) DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE category CHANGE is_active is_active TINYINT(1) DEFAULT 1 NOT NULL, CHANGE position position INT DEFAULT 999 NOT NULL');
        $this->addSql('ALTER TABLE country CHANGE is_active is_active TINYINT(1) DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE currency CHANGE is_protected is_protected TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE customer CHANGE is_active is_active TINYINT(1) DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE payment_method CHANGE is_active is_active TINYINT(1) DEFAULT 1 NOT NULL, CHANGE position position INT DEFAULT 999 NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE is_active is_active TINYINT(1) DEFAULT 1 NOT NULL, CHANGE position position INT DEFAULT 999 NOT NULL');
        $this->addSql('ALTER TABLE product_image CHANGE position position INT DEFAULT 999 NOT NULL');
        $this->addSql('ALTER TABLE promotion CHANGE is_active is_active TINYINT(1) DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE setting CHANGE is_active is_active TINYINT(1) DEFAULT 1 NOT NULL, CHANGE is_protected is_protected TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE tag CHANGE is_active is_active TINYINT(1) DEFAULT 1 NOT NULL, CHANGE position position INT DEFAULT 999 NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE is_active is_active TINYINT(1) DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE warehouse CHANGE is_active is_active TINYINT(1) DEFAULT 1 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category CHANGE is_active is_active TINYINT(1) DEFAULT 0 NOT NULL, CHANGE position position INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE product_image CHANGE position position INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE carrier CHANGE is_active is_active TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE payment_method CHANGE is_active is_active TINYINT(1) DEFAULT 0 NOT NULL, CHANGE position position INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE currency CHANGE is_protected is_protected TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE brand CHANGE is_active is_active TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE promotion CHANGE is_active is_active TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE country CHANGE is_active is_active TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE is_active is_active TINYINT(1) DEFAULT 0 NOT NULL, CHANGE position position INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE attribute CHANGE position position INT DEFAULT 0 NOT NULL, CHANGE is_active is_active TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE customer CHANGE is_active is_active TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE setting CHANGE is_active is_active TINYINT(1) DEFAULT 0 NOT NULL, CHANGE is_protected is_protected TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE tag CHANGE is_active is_active TINYINT(1) DEFAULT 0 NOT NULL, CHANGE position position INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE attribute_value CHANGE position position INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE warehouse CHANGE is_active is_active TINYINT(1) DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE is_active is_active TINYINT(1) DEFAULT 0 NOT NULL');
    }
}
