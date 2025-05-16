<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250516025933 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders ADD firstname VARCHAR(255) NOT NULL, ADD surname VARCHAR(255) NOT NULL, DROP first_name, DROP last_name, CHANGE phone_number phone VARCHAR(25) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E52FFDEEE7927C74 ON orders (email)');
        $this->addSql('ALTER TABLE payment ADD payment_method BIGINT DEFAULT NULL, CHANGE gateway_transaction_id gateway_transaction_id VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D7B61A1F6 FOREIGN KEY (payment_method) REFERENCES payment_method (id) ON DELETE SET NULL');
        $this->addSql('CREATE INDEX IDX_6D28840D7B61A1F6 ON payment (payment_method)');
        $this->addSql('ALTER TABLE payment_method ADD requires_webhook TINYINT(1) DEFAULT 0 NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE payment_method DROP requires_webhook');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D7B61A1F6');
        $this->addSql('DROP INDEX IDX_6D28840D7B61A1F6 ON payment');
        $this->addSql('ALTER TABLE payment DROP payment_method, CHANGE gateway_transaction_id gateway_transaction_id VARCHAR(100) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_E52FFDEEE7927C74 ON orders');
        $this->addSql('ALTER TABLE orders ADD first_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL, DROP firstname, DROP surname, CHANGE phone phone_number VARCHAR(25) NOT NULL');
    }
}
