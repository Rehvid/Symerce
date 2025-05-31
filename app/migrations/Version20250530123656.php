<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250530123656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders DROP INDEX IDX_E52FFDEEEBF23851, ADD UNIQUE INDEX UNIQ_E52FFDEEEBF23851 (delivery_address_id)');
        $this->addSql('ALTER TABLE orders DROP INDEX IDX_E52FFDEEC6BDFEB, ADD UNIQUE INDEX UNIQ_E52FFDEEC6BDFEB (invoice_address_id)');
        $this->addSql('ALTER TABLE orders DROP INDEX IDX_E52FFDEE7CA35EB5, ADD UNIQUE INDEX UNIQ_E52FFDEE7CA35EB5 (contact_details_id)');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEC6BDFEB');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE7CA35EB5');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEEBF23851');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEC6BDFEB FOREIGN KEY (invoice_address_id) REFERENCES invoice_address (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE7CA35EB5 FOREIGN KEY (contact_details_id) REFERENCES contact_details (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEEBF23851 FOREIGN KEY (delivery_address_id) REFERENCES delivery_address (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders DROP INDEX UNIQ_E52FFDEEEBF23851, ADD INDEX IDX_E52FFDEEEBF23851 (delivery_address_id)');
        $this->addSql('ALTER TABLE orders DROP INDEX UNIQ_E52FFDEEC6BDFEB, ADD INDEX IDX_E52FFDEEC6BDFEB (invoice_address_id)');
        $this->addSql('ALTER TABLE orders DROP INDEX UNIQ_E52FFDEE7CA35EB5, ADD INDEX IDX_E52FFDEE7CA35EB5 (contact_details_id)');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEEBF23851');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEEC6BDFEB');
        $this->addSql('ALTER TABLE orders DROP FOREIGN KEY FK_E52FFDEE7CA35EB5');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEEBF23851 FOREIGN KEY (delivery_address_id) REFERENCES delivery_address (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEEC6BDFEB FOREIGN KEY (invoice_address_id) REFERENCES invoice_address (id)');
        $this->addSql('ALTER TABLE orders ADD CONSTRAINT FK_E52FFDEE7CA35EB5 FOREIGN KEY (contact_details_id) REFERENCES invoice_address (id)');
    }
}
