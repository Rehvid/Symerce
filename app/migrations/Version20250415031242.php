<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250415031242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE carrier (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, fee NUMERIC(10, 2) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, is_active TINYINT(1) DEFAULT 0 NOT NULL, image_id BIGINT DEFAULT NULL, INDEX IDX_4739F11C3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE currency (id BIGINT AUTO_INCREMENT NOT NULL, code VARCHAR(3) NOT NULL, symbol VARCHAR(10) NOT NULL, name VARCHAR(50) NOT NULL, rounding_precision INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE delivery_time (id BIGINT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, min_days INT NOT NULL, max_days INT NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE carrier_delivery_times (delivery_time_id BIGINT NOT NULL, carrier_id BIGINT NOT NULL, INDEX IDX_E036675354F462E5 (delivery_time_id), INDEX IDX_E036675321DFC797 (carrier_id), PRIMARY KEY(delivery_time_id, carrier_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE global_settings (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE carrier ADD CONSTRAINT FK_4739F11C3DA5256D FOREIGN KEY (image_id) REFERENCES file (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE carrier_delivery_times ADD CONSTRAINT FK_E036675354F462E5 FOREIGN KEY (delivery_time_id) REFERENCES delivery_time (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE carrier_delivery_times ADD CONSTRAINT FK_E036675321DFC797 FOREIGN KEY (carrier_id) REFERENCES carrier (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carrier DROP FOREIGN KEY FK_4739F11C3DA5256D');
        $this->addSql('ALTER TABLE carrier_delivery_times DROP FOREIGN KEY FK_E036675354F462E5');
        $this->addSql('ALTER TABLE carrier_delivery_times DROP FOREIGN KEY FK_E036675321DFC797');
        $this->addSql('DROP TABLE carrier');
        $this->addSql('DROP TABLE currency');
        $this->addSql('DROP TABLE delivery_time');
        $this->addSql('DROP TABLE carrier_delivery_times');
        $this->addSql('DROP TABLE global_settings');
    }
}
