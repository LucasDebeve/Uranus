<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240521165845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE suivi DROP CONSTRAINT fk_2ebcca8feca105f7');
        $this->addSql('ALTER TABLE suivi DROP CONSTRAINT fk_2ebcca8fc1fc762e');
        $this->addSql('DROP INDEX idx_2ebcca8fc1fc762e');
        $this->addSql('DROP INDEX idx_2ebcca8feca105f7');
        $this->addSql('ALTER TABLE suivi ADD eleve_id INT NOT NULL');
        $this->addSql('ALTER TABLE suivi ADD plan_de_travail_id INT NOT NULL');
        $this->addSql('ALTER TABLE suivi DROP eleve');
        $this->addSql('ALTER TABLE suivi DROP plan_de_travail');
        $this->addSql('ALTER TABLE suivi ADD CONSTRAINT FK_2EBCCA8FA6CC7B2 FOREIGN KEY (eleve_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE suivi ADD CONSTRAINT FK_2EBCCA8F99FCCE5C FOREIGN KEY (plan_de_travail_id) REFERENCES plan_de_travail (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2EBCCA8FA6CC7B2 ON suivi (eleve_id)');
        $this->addSql('CREATE INDEX IDX_2EBCCA8F99FCCE5C ON suivi (plan_de_travail_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE suivi DROP CONSTRAINT FK_2EBCCA8FA6CC7B2');
        $this->addSql('ALTER TABLE suivi DROP CONSTRAINT FK_2EBCCA8F99FCCE5C');
        $this->addSql('DROP INDEX IDX_2EBCCA8FA6CC7B2');
        $this->addSql('DROP INDEX IDX_2EBCCA8F99FCCE5C');
        $this->addSql('ALTER TABLE suivi ADD eleve INT NOT NULL');
        $this->addSql('ALTER TABLE suivi ADD plan_de_travail INT NOT NULL');
        $this->addSql('ALTER TABLE suivi DROP eleve_id');
        $this->addSql('ALTER TABLE suivi DROP plan_de_travail_id');
        $this->addSql('ALTER TABLE suivi ADD CONSTRAINT fk_2ebcca8feca105f7 FOREIGN KEY (eleve) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE suivi ADD CONSTRAINT fk_2ebcca8fc1fc762e FOREIGN KEY (plan_de_travail) REFERENCES plan_de_travail (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_2ebcca8fc1fc762e ON suivi (plan_de_travail)');
        $this->addSql('CREATE INDEX idx_2ebcca8feca105f7 ON suivi (eleve)');
    }
}
