<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250416124454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carrier CHANGE fee fee NUMERIC(20, 8) NOT NULL');
        $this->addSql('ALTER TABLE currency CHANGE rounding_precision rounding_precision SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE payment_method CHANGE fee fee NUMERIC(20, 8) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carrier CHANGE fee fee NUMERIC(10, 2) NOT NULL');
        $this->addSql('ALTER TABLE payment_method CHANGE fee fee NUMERIC(10, 2) NOT NULL');
        $this->addSql('ALTER TABLE currency CHANGE rounding_precision rounding_precision INT NOT NULL');
    }
}
