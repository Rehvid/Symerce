<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250603024332 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD meta_title VARCHAR(255) DEFAULT NULL, ADD meta_description VARCHAR(500) DEFAULT NULL');
        $this->addSql('ALTER TABLE product_attribute CHANGE custom_value custom_value LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP meta_title, DROP meta_description');
        $this->addSql('ALTER TABLE product_attribute CHANGE custom_value custom_value VARCHAR(255) DEFAULT NULL');
    }
}
