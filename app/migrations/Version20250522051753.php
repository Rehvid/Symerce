<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250522051753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_stock (id BIGINT AUTO_INCREMENT NOT NULL, available_quantity INT NOT NULL, low_stock_threshold INT DEFAULT NULL, maximum_stock_level INT DEFAULT NULL, notify_on_low_stock TINYINT(1) DEFAULT 1 NOT NULL, visible_in_store TINYINT(1) DEFAULT 1 NOT NULL, product_id BIGINT NOT NULL, UNIQUE INDEX UNIQ_EA6A2D3C4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE product_stock ADD CONSTRAINT FK_EA6A2D3C4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_stock DROP FOREIGN KEY FK_EA6A2D3C4584665A');
        $this->addSql('DROP TABLE product_stock');
    }
}
