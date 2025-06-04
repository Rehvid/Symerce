<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250603181204 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_EA6A2D3CF9038C4 ON product_stock');
        $this->addSql('DROP INDEX UNIQ_EA6A2D3C2FAE1FC8 ON product_stock');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EA6A2D3CF9038C4 ON product_stock (sku)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EA6A2D3C2FAE1FC8 ON product_stock (ean13)');
    }
}
