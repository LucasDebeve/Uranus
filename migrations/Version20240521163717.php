<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240521163717 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE suivi_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE suivi (id INT NOT NULL, eleve_id INT NOT NULL, plan_de_travail_id INT NOT NULL, progression INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2EBCCA8FA6CC7B2 ON suivi (eleve_id)');
        $this->addSql('CREATE INDEX IDX_2EBCCA8F99FCCE5C ON suivi (plan_de_travail_id)');
        $this->addSql('ALTER TABLE suivi ADD CONSTRAINT FK_2EBCCA8FA6CC7B2 FOREIGN KEY (eleve_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE suivi ADD CONSTRAINT FK_2EBCCA8F99FCCE5C FOREIGN KEY (plan_de_travail_id) REFERENCES plan_de_travail (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE suivi_id_seq CASCADE');
        $this->addSql('ALTER TABLE suivi DROP CONSTRAINT FK_2EBCCA8FA6CC7B2');
        $this->addSql('ALTER TABLE suivi DROP CONSTRAINT FK_2EBCCA8F99FCCE5C');
        $this->addSql('DROP TABLE suivi');
    }
}
