<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250604121029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carrier_delivery_times DROP FOREIGN KEY FK_E036675321DFC797');
        $this->addSql('ALTER TABLE carrier_delivery_times DROP FOREIGN KEY FK_E036675354F462E5');
        $this->addSql('DROP TABLE carrier_delivery_times');
        $this->addSql('DROP TABLE delivery_time');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE carrier_delivery_times (delivery_time_id BIGINT NOT NULL, carrier_id BIGINT NOT NULL, INDEX IDX_E036675321DFC797 (carrier_id), INDEX IDX_E036675354F462E5 (delivery_time_id), PRIMARY KEY(delivery_time_id, carrier_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE delivery_time (id BIGINT AUTO_INCREMENT NOT NULL, label VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, min_days INT NOT NULL, max_days INT NOT NULL, type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, is_active TINYINT(1) DEFAULT 0 NOT NULL, position INT DEFAULT 0 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE carrier_delivery_times ADD CONSTRAINT FK_E036675321DFC797 FOREIGN KEY (carrier_id) REFERENCES carrier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE carrier_delivery_times ADD CONSTRAINT FK_E036675354F462E5 FOREIGN KEY (delivery_time_id) REFERENCES delivery_time (id) ON DELETE CASCADE');
    }
}
