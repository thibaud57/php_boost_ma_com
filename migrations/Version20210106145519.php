<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210106145519 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF4427EB8A5');
        $this->addSql('CREATE TABLE rqst (id INT AUTO_INCREMENT NOT NULL, customer_id INT NOT NULL, object VARCHAR(80) NOT NULL, content LONGTEXT NOT NULL, status LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_E63B2A7C9395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rqst ADD CONSTRAINT FK_E63B2A7C9395C3F3 FOREIGN KEY (customer_id) REFERENCES customers (id)');
        $this->addSql('DROP TABLE requests');
        $this->addSql('DROP INDEX UNIQ_54469DF4427EB8A5 ON tickets');
        $this->addSql('ALTER TABLE tickets CHANGE request_id rqst_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF4E5CA71EE FOREIGN KEY (rqst_id) REFERENCES rqst (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_54469DF4E5CA71EE ON tickets (rqst_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF4E5CA71EE');
        $this->addSql('CREATE TABLE requests (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, object VARCHAR(80) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, content LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, status LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', INDEX IDX_7B85D6519395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE requests ADD CONSTRAINT FK_7B85D6519395C3F3 FOREIGN KEY (customer_id) REFERENCES customers (id)');
        $this->addSql('DROP TABLE rqst');
        $this->addSql('DROP INDEX UNIQ_54469DF4E5CA71EE ON tickets');
        $this->addSql('ALTER TABLE tickets CHANGE rqst_id request_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF4427EB8A5 FOREIGN KEY (request_id) REFERENCES requests (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_54469DF4427EB8A5 ON tickets (request_id)');
    }
}
