<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250320031750 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL, is_active TINYINT(1) DEFAULT 0 NOT NULL, `order` INT DEFAULT 0 NOT NULL, parent_id BIGINT DEFAULT NULL, INDEX IDX_64C19C1727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE products_categories (category_id BIGINT NOT NULL, product_id BIGINT NOT NULL, INDEX IDX_E8ACBE7612469DE2 (category_id), INDEX IDX_E8ACBE764584665A (product_id), PRIMARY KEY(category_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE product (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, update_at DATETIME NOT NULL, is_active TINYINT(1) DEFAULT 0 NOT NULL, `order` INT DEFAULT 0 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE products_categories ADD CONSTRAINT FK_E8ACBE7612469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products_categories ADD CONSTRAINT FK_E8ACBE764584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1727ACA70');
        $this->addSql('ALTER TABLE products_categories DROP FOREIGN KEY FK_E8ACBE7612469DE2');
        $this->addSql('ALTER TABLE products_categories DROP FOREIGN KEY FK_E8ACBE764584665A');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE products_categories');
        $this->addSql('DROP TABLE product');
    }
}
