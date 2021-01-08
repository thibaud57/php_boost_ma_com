<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210108134943 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rqst DROP FOREIGN KEY FK_E63B2A7C9395C3F3');
        $this->addSql('DROP INDEX IDX_E63B2A7C9395C3F3 ON rqst');
        $this->addSql('ALTER TABLE rqst ADD user_id INT DEFAULT NULL, DROP customer_id');
        $this->addSql('ALTER TABLE rqst ADD CONSTRAINT FK_E63B2A7CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_E63B2A7CA76ED395 ON rqst (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rqst DROP FOREIGN KEY FK_E63B2A7CA76ED395');
        $this->addSql('DROP INDEX IDX_E63B2A7CA76ED395 ON rqst');
        $this->addSql('ALTER TABLE rqst ADD customer_id INT NOT NULL, DROP user_id');
        $this->addSql('ALTER TABLE rqst ADD CONSTRAINT FK_E63B2A7C9395C3F3 FOREIGN KEY (customer_id) REFERENCES customers (id)');
        $this->addSql('CREATE INDEX IDX_E63B2A7C9395C3F3 ON rqst (customer_id)');
    }
}
