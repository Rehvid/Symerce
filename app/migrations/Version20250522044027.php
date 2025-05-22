<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250522044027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_price_history ADD discount_price NUMERIC(20, 8) DEFAULT NULL, DROP changed_at, DROP updated_at, CHANGE price base_price NUMERIC(20, 8) NOT NULL');
        $this->addSql('ALTER TABLE promotion CHANGE starts_at starts_at DATE NOT NULL, CHANGE ends_at ends_at DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE promotion CHANGE starts_at starts_at DATETIME NOT NULL, CHANGE ends_at ends_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE product_price_history ADD changed_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, DROP discount_price, CHANGE base_price price NUMERIC(20, 8) NOT NULL');
    }
}
