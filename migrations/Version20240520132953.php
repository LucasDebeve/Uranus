<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240520132953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE sequence_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE sequence (id INT NOT NULL, plan_de_travail_id INT NOT NULL, titre VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, date_deb TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_fin TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_5286D72B99FCCE5C ON sequence (plan_de_travail_id)');
        $this->addSql('ALTER TABLE sequence ADD CONSTRAINT FK_5286D72B99FCCE5C FOREIGN KEY (plan_de_travail_id) REFERENCES plan_de_travail (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE sequence_id_seq CASCADE');
        $this->addSql('ALTER TABLE sequence DROP CONSTRAINT FK_5286D72B99FCCE5C');
        $this->addSql('DROP TABLE sequence');
    }
}
