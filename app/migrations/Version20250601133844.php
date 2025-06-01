<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250601133844 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carrier DROP FOREIGN KEY FK_4739F11C3DA5256D');
        $this->addSql('DROP INDEX IDX_4739F11C3DA5256D ON carrier');
        $this->addSql('ALTER TABLE carrier ADD external_data JSON DEFAULT NULL, ADD is_external TINYINT(1) NOT NULL, CHANGE fee fee NUMERIC(20, 8) DEFAULT NULL, CHANGE image_id thumbnail_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE carrier ADD CONSTRAINT FK_4739F11CFDFF2E92 FOREIGN KEY (thumbnail_id) REFERENCES file (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_4739F11CFDFF2E92 ON carrier (thumbnail_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carrier DROP FOREIGN KEY FK_4739F11CFDFF2E92');
        $this->addSql('DROP INDEX IDX_4739F11CFDFF2E92 ON carrier');
        $this->addSql('ALTER TABLE carrier DROP external_data, DROP is_external, CHANGE fee fee NUMERIC(20, 8) NOT NULL, CHANGE thumbnail_id image_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE carrier ADD CONSTRAINT FK_4739F11C3DA5256D FOREIGN KEY (image_id) REFERENCES file (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_4739F11C3DA5256D ON carrier (image_id)');
    }
}
