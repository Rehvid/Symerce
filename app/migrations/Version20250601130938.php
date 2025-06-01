<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250601130938 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_stock DROP INDEX UNIQ_EA6A2D3C4584665A, ADD INDEX IDX_EA6A2D3C4584665A (product_id)');
        $this->addSql('ALTER TABLE product_stock ADD restock_date DATETIME DEFAULT NULL, ADD warehouse_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_stock ADD CONSTRAINT FK_EA6A2D3C5080ECDE FOREIGN KEY (warehouse_id) REFERENCES warehouse (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_EA6A2D3C5080ECDE ON product_stock (warehouse_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_stock DROP INDEX IDX_EA6A2D3C4584665A, ADD UNIQUE INDEX UNIQ_EA6A2D3C4584665A (product_id)');
        $this->addSql('ALTER TABLE product_stock DROP FOREIGN KEY FK_EA6A2D3C5080ECDE');
        $this->addSql('DROP INDEX IDX_EA6A2D3C5080ECDE ON product_stock');
        $this->addSql('ALTER TABLE product_stock DROP restock_date, DROP warehouse_id');
    }
}
