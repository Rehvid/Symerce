<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250423114323 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_category (product_id BIGINT NOT NULL, category_id BIGINT NOT NULL, INDEX IDX_CDFC73564584665A (product_id), INDEX IDX_CDFC735612469DE2 (category_id), PRIMARY KEY(product_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE product_tag (product_id BIGINT NOT NULL, tag_id BIGINT NOT NULL, INDEX IDX_E3A6E39C4584665A (product_id), INDEX IDX_E3A6E39CBAD26311 (tag_id), PRIMARY KEY(product_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE product_delivery_time (product_id BIGINT NOT NULL, delivery_time_id BIGINT NOT NULL, INDEX IDX_64E54C2D4584665A (product_id), INDEX IDX_64E54C2D54F462E5 (delivery_time_id), PRIMARY KEY(product_id, delivery_time_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE product_image (product_id BIGINT NOT NULL, file_id BIGINT NOT NULL, INDEX IDX_64617F034584665A (product_id), INDEX IDX_64617F0393CB796C (file_id), PRIMARY KEY(product_id, file_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE product_attribute_value (product_id BIGINT NOT NULL, attribute_value_id BIGINT NOT NULL, INDEX IDX_CCC4BE1F4584665A (product_id), INDEX IDX_CCC4BE1F65A22152 (attribute_value_id), PRIMARY KEY(product_id, attribute_value_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE product_category ADD CONSTRAINT FK_CDFC73564584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_category ADD CONSTRAINT FK_CDFC735612469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_tag ADD CONSTRAINT FK_E3A6E39C4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_tag ADD CONSTRAINT FK_E3A6E39CBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_delivery_time ADD CONSTRAINT FK_64E54C2D4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_delivery_time ADD CONSTRAINT FK_64E54C2D54F462E5 FOREIGN KEY (delivery_time_id) REFERENCES delivery_time (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_image ADD CONSTRAINT FK_64617F034584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_image ADD CONSTRAINT FK_64617F0393CB796C FOREIGN KEY (file_id) REFERENCES file (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_attribute_value ADD CONSTRAINT FK_CCC4BE1F4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_attribute_value ADD CONSTRAINT FK_CCC4BE1F65A22152 FOREIGN KEY (attribute_value_id) REFERENCES attribute_value (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product ADD slug VARCHAR(255) NOT NULL, ADD regular_price NUMERIC(20, 8) NOT NULL, ADD discount_price NUMERIC(20, 8) NOT NULL, ADD quantity INT UNSIGNED DEFAULT 0 NOT NULL, ADD vendor_id BIGINT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADF603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_D34A04ADF603EE73 ON product (vendor_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_category DROP FOREIGN KEY FK_CDFC73564584665A');
        $this->addSql('ALTER TABLE product_category DROP FOREIGN KEY FK_CDFC735612469DE2');
        $this->addSql('ALTER TABLE product_tag DROP FOREIGN KEY FK_E3A6E39C4584665A');
        $this->addSql('ALTER TABLE product_tag DROP FOREIGN KEY FK_E3A6E39CBAD26311');
        $this->addSql('ALTER TABLE product_delivery_time DROP FOREIGN KEY FK_64E54C2D4584665A');
        $this->addSql('ALTER TABLE product_delivery_time DROP FOREIGN KEY FK_64E54C2D54F462E5');
        $this->addSql('ALTER TABLE product_image DROP FOREIGN KEY FK_64617F034584665A');
        $this->addSql('ALTER TABLE product_image DROP FOREIGN KEY FK_64617F0393CB796C');
        $this->addSql('ALTER TABLE product_attribute_value DROP FOREIGN KEY FK_CCC4BE1F4584665A');
        $this->addSql('ALTER TABLE product_attribute_value DROP FOREIGN KEY FK_CCC4BE1F65A22152');
        $this->addSql('DROP TABLE product_category');
        $this->addSql('DROP TABLE product_tag');
        $this->addSql('DROP TABLE product_delivery_time');
        $this->addSql('DROP TABLE product_image');
        $this->addSql('DROP TABLE product_attribute_value');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADF603EE73');
        $this->addSql('DROP INDEX IDX_D34A04ADF603EE73 ON product');
        $this->addSql('ALTER TABLE product DROP slug, DROP regular_price, DROP discount_price, DROP quantity, DROP vendor_id');
    }
}
