<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210106142321 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE requests (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, object VARCHAR(80) NOT NULL, content LONGTEXT NOT NULL, status LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_7B85D6519395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tickets (id INT AUTO_INCREMENT NOT NULL, request_id INT DEFAULT NULL, object VARCHAR(80) NOT NULL, content LONGTEXT NOT NULL, status LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_54469DF4427EB8A5 (request_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE requests ADD CONSTRAINT FK_7B85D6519395C3F3 FOREIGN KEY (customer_id) REFERENCES customers (id)');
        $this->addSql('ALTER TABLE tickets ADD CONSTRAINT FK_54469DF4427EB8A5 FOREIGN KEY (request_id) REFERENCES requests (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tickets DROP FOREIGN KEY FK_54469DF4427EB8A5');
        $this->addSql('DROP TABLE requests');
        $this->addSql('DROP TABLE tickets');
    }
}
