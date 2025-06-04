<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250603151255 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP quantity');
        $this->addSql('ALTER TABLE product_stock DROP notify_on_low_stock, DROP visible_in_store');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_stock ADD notify_on_low_stock TINYINT(1) DEFAULT 1 NOT NULL, ADD visible_in_store TINYINT(1) DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE product ADD quantity INT UNSIGNED DEFAULT 0 NOT NULL');
    }
}
