<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250512025316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attribute (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, `order` INT DEFAULT 0 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE attribute_value (id BIGINT AUTO_INCREMENT NOT NULL, value VARCHAR(255) NOT NULL, `order` INT DEFAULT 0 NOT NULL, attribute_id BIGINT DEFAULT NULL, INDEX IDX_FE4FBB82B6E62EFA (attribute_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE carrier (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, fee NUMERIC(20, 8) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, is_active TINYINT(1) DEFAULT 0 NOT NULL, image_id BIGINT DEFAULT NULL, INDEX IDX_4739F11C3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE category (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, is_active TINYINT(1) DEFAULT 0 NOT NULL, `order` INT DEFAULT 0 NOT NULL, parent_id BIGINT DEFAULT NULL, image_id BIGINT DEFAULT NULL, INDEX IDX_64C19C1727ACA70 (parent_id), INDEX IDX_64C19C13DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE currency (id BIGINT AUTO_INCREMENT NOT NULL, code VARCHAR(3) NOT NULL, symbol VARCHAR(10) NOT NULL, name VARCHAR(50) NOT NULL, rounding_precision SMALLINT NOT NULL, is_protected TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE delivery_time (id BIGINT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, min_days INT NOT NULL, max_days INT NOT NULL, type VARCHAR(255) NOT NULL, is_active TINYINT(1) DEFAULT 0 NOT NULL, `order` INT DEFAULT 0 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE carrier_delivery_times (delivery_time_id BIGINT NOT NULL, carrier_id BIGINT NOT NULL, INDEX IDX_E036675354F462E5 (delivery_time_id), INDEX IDX_E036675321DFC797 (carrier_id), PRIMARY KEY(delivery_time_id, carrier_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE file (id BIGINT AUTO_INCREMENT NOT NULL, original_name VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, mime_type VARCHAR(255) NOT NULL, size INT NOT NULL, path VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE payment_method (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, fee NUMERIC(20, 8) NOT NULL, is_active TINYINT(1) DEFAULT 0 NOT NULL, `order` INT DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, image_id BIGINT DEFAULT NULL, INDEX IDX_7B61A1F63DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE product (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, slug VARCHAR(255) NOT NULL, regular_price NUMERIC(20, 8) NOT NULL, discount_price NUMERIC(20, 8) DEFAULT NULL, quantity INT UNSIGNED DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, is_active TINYINT(1) DEFAULT 0 NOT NULL, `order` INT DEFAULT 0 NOT NULL, vendor_id BIGINT DEFAULT NULL, delivery_time_id BIGINT DEFAULT NULL, INDEX IDX_D34A04ADF603EE73 (vendor_id), INDEX IDX_D34A04AD54F462E5 (delivery_time_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE product_categories (product_id BIGINT NOT NULL, category_id BIGINT NOT NULL, INDEX IDX_A99419434584665A (product_id), INDEX IDX_A994194312469DE2 (category_id), PRIMARY KEY(product_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE product_tag (product_id BIGINT NOT NULL, tag_id BIGINT NOT NULL, INDEX IDX_E3A6E39C4584665A (product_id), INDEX IDX_E3A6E39CBAD26311 (tag_id), PRIMARY KEY(product_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE product_attribute (product_id BIGINT NOT NULL, attribute_id BIGINT NOT NULL, INDEX IDX_94DA59764584665A (product_id), INDEX IDX_94DA5976B6E62EFA (attribute_id), PRIMARY KEY(product_id, attribute_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE product_image (id INT AUTO_INCREMENT NOT NULL, is_thumbnail TINYINT(1) NOT NULL, product_id BIGINT DEFAULT NULL, file_id BIGINT DEFAULT NULL, INDEX IDX_64617F034584665A (product_id), INDEX IDX_64617F0393CB796C (file_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE setting (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, value LONGTEXT NOT NULL, type VARCHAR(255) NOT NULL, is_json TINYINT(1) DEFAULT 0 NOT NULL, created_at DATETIME NOT NULL, is_active TINYINT(1) DEFAULT 0 NOT NULL, is_protected TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE tag (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE user (id BIGINT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, is_active TINYINT(1) DEFAULT 0 NOT NULL, avatar_id BIGINT DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D64986383B10 (avatar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE user_token (id BIGINT AUTO_INCREMENT NOT NULL, token VARCHAR(255) NOT NULL, expires_at DATETIME NOT NULL, token_type VARCHAR(255) NOT NULL, user_id BIGINT DEFAULT NULL, INDEX IDX_BDF55A63A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE vendor (id BIGINT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, is_active TINYINT(1) DEFAULT 0 NOT NULL, image_id BIGINT DEFAULT NULL, INDEX IDX_F52233F63DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE attribute_value ADD CONSTRAINT FK_FE4FBB82B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE carrier ADD CONSTRAINT FK_4739F11C3DA5256D FOREIGN KEY (image_id) REFERENCES file (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1727ACA70 FOREIGN KEY (parent_id) REFERENCES category (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C13DA5256D FOREIGN KEY (image_id) REFERENCES file (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE carrier_delivery_times ADD CONSTRAINT FK_E036675354F462E5 FOREIGN KEY (delivery_time_id) REFERENCES delivery_time (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE carrier_delivery_times ADD CONSTRAINT FK_E036675321DFC797 FOREIGN KEY (carrier_id) REFERENCES carrier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE payment_method ADD CONSTRAINT FK_7B61A1F63DA5256D FOREIGN KEY (image_id) REFERENCES file (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADF603EE73 FOREIGN KEY (vendor_id) REFERENCES vendor (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD54F462E5 FOREIGN KEY (delivery_time_id) REFERENCES delivery_time (id)');
        $this->addSql('ALTER TABLE product_categories ADD CONSTRAINT FK_A99419434584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_categories ADD CONSTRAINT FK_A994194312469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_tag ADD CONSTRAINT FK_E3A6E39C4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_tag ADD CONSTRAINT FK_E3A6E39CBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_attribute ADD CONSTRAINT FK_94DA59764584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_attribute ADD CONSTRAINT FK_94DA5976B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_image ADD CONSTRAINT FK_64617F034584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product_image ADD CONSTRAINT FK_64617F0393CB796C FOREIGN KEY (file_id) REFERENCES file (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64986383B10 FOREIGN KEY (avatar_id) REFERENCES file (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE user_token ADD CONSTRAINT FK_BDF55A63A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vendor ADD CONSTRAINT FK_F52233F63DA5256D FOREIGN KEY (image_id) REFERENCES file (id) ON DELETE SET NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE attribute_value DROP FOREIGN KEY FK_FE4FBB82B6E62EFA');
        $this->addSql('ALTER TABLE carrier DROP FOREIGN KEY FK_4739F11C3DA5256D');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1727ACA70');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C13DA5256D');
        $this->addSql('ALTER TABLE carrier_delivery_times DROP FOREIGN KEY FK_E036675354F462E5');
        $this->addSql('ALTER TABLE carrier_delivery_times DROP FOREIGN KEY FK_E036675321DFC797');
        $this->addSql('ALTER TABLE payment_method DROP FOREIGN KEY FK_7B61A1F63DA5256D');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADF603EE73');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD54F462E5');
        $this->addSql('ALTER TABLE product_categories DROP FOREIGN KEY FK_A99419434584665A');
        $this->addSql('ALTER TABLE product_categories DROP FOREIGN KEY FK_A994194312469DE2');
        $this->addSql('ALTER TABLE product_tag DROP FOREIGN KEY FK_E3A6E39C4584665A');
        $this->addSql('ALTER TABLE product_tag DROP FOREIGN KEY FK_E3A6E39CBAD26311');
        $this->addSql('ALTER TABLE product_attribute DROP FOREIGN KEY FK_94DA59764584665A');
        $this->addSql('ALTER TABLE product_attribute DROP FOREIGN KEY FK_94DA5976B6E62EFA');
        $this->addSql('ALTER TABLE product_image DROP FOREIGN KEY FK_64617F034584665A');
        $this->addSql('ALTER TABLE product_image DROP FOREIGN KEY FK_64617F0393CB796C');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64986383B10');
        $this->addSql('ALTER TABLE user_token DROP FOREIGN KEY FK_BDF55A63A76ED395');
        $this->addSql('ALTER TABLE vendor DROP FOREIGN KEY FK_F52233F63DA5256D');
        $this->addSql('DROP TABLE attribute');
        $this->addSql('DROP TABLE attribute_value');
        $this->addSql('DROP TABLE carrier');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE currency');
        $this->addSql('DROP TABLE delivery_time');
        $this->addSql('DROP TABLE carrier_delivery_times');
        $this->addSql('DROP TABLE file');
        $this->addSql('DROP TABLE payment_method');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE product_categories');
        $this->addSql('DROP TABLE product_tag');
        $this->addSql('DROP TABLE product_attribute');
        $this->addSql('DROP TABLE product_image');
        $this->addSql('DROP TABLE setting');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user_token');
        $this->addSql('DROP TABLE vendor');
    }
}
