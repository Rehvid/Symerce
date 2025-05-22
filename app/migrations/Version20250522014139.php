<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250522014139 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_price_history (id BIGINT AUTO_INCREMENT NOT NULL, price NUMERIC(20, 8) NOT NULL, changed_at DATETIME NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, product_id BIGINT NOT NULL, INDEX IDX_9671A4E54584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE promotion (id BIGINT AUTO_INCREMENT NOT NULL, starts_at DATETIME NOT NULL, ends_at DATETIME NOT NULL, reduction NUMERIC(20, 8) NOT NULL, type VARCHAR(255) NOT NULL, from_quantity INT UNSIGNED DEFAULT 1 NOT NULL, usage_limit INT UNSIGNED DEFAULT NULL, usage_per_user INT UNSIGNED DEFAULT NULL, coupon_code VARCHAR(100) DEFAULT NULL, priority INT UNSIGNED DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, is_active TINYINT(1) DEFAULT 0 NOT NULL, product_id BIGINT DEFAULT NULL, INDEX IDX_C11D7DD14584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE product_price_history ADD CONSTRAINT FK_9671A4E54584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promotion ADD CONSTRAINT FK_C11D7DD14584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE product DROP discount_price');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_price_history DROP FOREIGN KEY FK_9671A4E54584665A');
        $this->addSql('ALTER TABLE promotion DROP FOREIGN KEY FK_C11D7DD14584665A');
        $this->addSql('DROP TABLE product_price_history');
        $this->addSql('DROP TABLE promotion');
        $this->addSql('ALTER TABLE product ADD discount_price NUMERIC(20, 8) DEFAULT NULL');
    }
}
