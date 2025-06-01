<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250601060823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brand (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_active TINYINT(1) DEFAULT 0 NOT NULL, image_id BIGINT DEFAULT NULL, INDEX IDX_1C52F9583DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE brand ADD CONSTRAINT FK_1C52F9583DA5256D FOREIGN KEY (image_id) REFERENCES file (id) ON DELETE SET NULL');
        $this->addSql('DROP TABLE vendor');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADF603EE73 FOREIGN KEY (vendor_id) REFERENCES brand (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vendor (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, is_active TINYINT(1) DEFAULT 0 NOT NULL, image_id BIGINT DEFAULT NULL, INDEX IDX_F52233F63DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE brand DROP FOREIGN KEY FK_1C52F9583DA5256D');
        $this->addSql('DROP TABLE brand');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADF603EE73');
    }
}
