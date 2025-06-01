<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250601060956 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADF603EE73');
        $this->addSql('DROP INDEX IDX_D34A04ADF603EE73 ON product');
        $this->addSql('ALTER TABLE product CHANGE vendor_id brand_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_D34A04AD44F5D008 ON product (brand_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD44F5D008');
        $this->addSql('DROP INDEX IDX_D34A04AD44F5D008 ON product');
        $this->addSql('ALTER TABLE product CHANGE brand_id vendor_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADF603EE73 FOREIGN KEY (vendor_id) REFERENCES brand (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_D34A04ADF603EE73 ON product (vendor_id)');
    }
}
