<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250512153824 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_attribute_value (product_id BIGINT NOT NULL, attribute_value_id BIGINT NOT NULL, INDEX IDX_CCC4BE1F4584665A (product_id), INDEX IDX_CCC4BE1F65A22152 (attribute_value_id), PRIMARY KEY(product_id, attribute_value_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE product_attribute_value ADD CONSTRAINT FK_CCC4BE1F4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_attribute_value ADD CONSTRAINT FK_CCC4BE1F65A22152 FOREIGN KEY (attribute_value_id) REFERENCES attribute_value (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_attribute DROP FOREIGN KEY FK_94DA59764584665A');
        $this->addSql('ALTER TABLE product_attribute DROP FOREIGN KEY FK_94DA5976B6E62EFA');
        $this->addSql('DROP TABLE product_attribute');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_attribute (product_id BIGINT NOT NULL, attribute_id BIGINT NOT NULL, INDEX IDX_94DA5976B6E62EFA (attribute_id), INDEX IDX_94DA59764584665A (product_id), PRIMARY KEY(product_id, attribute_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE product_attribute ADD CONSTRAINT FK_94DA59764584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_attribute ADD CONSTRAINT FK_94DA5976B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_attribute_value DROP FOREIGN KEY FK_CCC4BE1F4584665A');
        $this->addSql('ALTER TABLE product_attribute_value DROP FOREIGN KEY FK_CCC4BE1F65A22152');
        $this->addSql('DROP TABLE product_attribute_value');
    }
}
