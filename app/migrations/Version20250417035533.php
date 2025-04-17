<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250417035533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE setting (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, is_protected TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, is_active TINYINT(1) DEFAULT 0 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('DROP TABLE global_settings');
        $this->addSql('ALTER TABLE attribute ADD `order` INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE attribute_value ADD `order` INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE delivery_time ADD is_active TINYINT(1) DEFAULT 0 NOT NULL, ADD `order` INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE payment_method ADD `order` INT DEFAULT 0 NOT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE user ADD updated_at DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE global_settings (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, is_protected TINYINT(1) NOT NULL, value VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE setting');
        $this->addSql('ALTER TABLE payment_method DROP `order`, DROP created_at, DROP updated_at');
        $this->addSql('ALTER TABLE attribute DROP `order`');
        $this->addSql('ALTER TABLE delivery_time DROP is_active, DROP `order`');
        $this->addSql('ALTER TABLE attribute_value DROP `order`');
        $this->addSql('ALTER TABLE user DROP updated_at');
    }
}
