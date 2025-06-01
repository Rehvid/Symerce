<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250601034434 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attribute CHANGE `order` position INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE attribute_value CHANGE `order` position INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE category CHANGE `order` position INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE delivery_time CHANGE `order` position INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE payment_method CHANGE `order` position INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE `order` position INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE product_image CHANGE `order` position INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE tag CHANGE `order` position INT DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category CHANGE position `order` INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE product_image CHANGE position `order` INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE payment_method CHANGE position `order` INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE product CHANGE position `order` INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE attribute CHANGE position `order` INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE delivery_time CHANGE position `order` INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE tag CHANGE position `order` INT DEFAULT 0 NOT NULL');
        $this->addSql('ALTER TABLE attribute_value CHANGE position `order` INT DEFAULT 0 NOT NULL');
    }
}
