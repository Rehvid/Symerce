<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250512025424 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD54F462E5');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD54F462E5 FOREIGN KEY (delivery_time_id) REFERENCES delivery_time (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD54F462E5');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD54F462E5 FOREIGN KEY (delivery_time_id) REFERENCES delivery_time (id)');
    }
}
