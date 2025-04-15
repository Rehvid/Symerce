<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250415031348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE payment_method (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, fee NUMERIC(10, 2) NOT NULL, is_active TINYINT(1) DEFAULT 0 NOT NULL, image_id BIGINT DEFAULT NULL, INDEX IDX_7B61A1F63DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE payment_method ADD CONSTRAINT FK_7B61A1F63DA5256D FOREIGN KEY (image_id) REFERENCES file (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment_method DROP FOREIGN KEY FK_7B61A1F63DA5256D');
        $this->addSql('DROP TABLE payment_method');
    }
}
