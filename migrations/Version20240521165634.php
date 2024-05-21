<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240521165634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE suivi DROP CONSTRAINT fk_2ebcca8fa6cc7b2');
        $this->addSql('ALTER TABLE suivi DROP CONSTRAINT fk_2ebcca8f99fcce5c');
        $this->addSql('DROP INDEX idx_2ebcca8f99fcce5c');
        $this->addSql('DROP INDEX idx_2ebcca8fa6cc7b2');
        $this->addSql('ALTER TABLE suivi ADD eleve INT NOT NULL');
        $this->addSql('ALTER TABLE suivi ADD plan_de_travail INT NOT NULL');
        $this->addSql('ALTER TABLE suivi DROP eleve_id');
        $this->addSql('ALTER TABLE suivi DROP plan_de_travail_id');
        $this->addSql('ALTER TABLE suivi ADD CONSTRAINT FK_2EBCCA8FECA105F7 FOREIGN KEY (eleve) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE suivi ADD CONSTRAINT FK_2EBCCA8FC1FC762E FOREIGN KEY (plan_de_travail) REFERENCES plan_de_travail (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_2EBCCA8FECA105F7 ON suivi (eleve)');
        $this->addSql('CREATE INDEX IDX_2EBCCA8FC1FC762E ON suivi (plan_de_travail)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE suivi DROP CONSTRAINT FK_2EBCCA8FECA105F7');
        $this->addSql('ALTER TABLE suivi DROP CONSTRAINT FK_2EBCCA8FC1FC762E');
        $this->addSql('DROP INDEX IDX_2EBCCA8FECA105F7');
        $this->addSql('DROP INDEX IDX_2EBCCA8FC1FC762E');
        $this->addSql('ALTER TABLE suivi ADD eleve_id INT NOT NULL');
        $this->addSql('ALTER TABLE suivi ADD plan_de_travail_id INT NOT NULL');
        $this->addSql('ALTER TABLE suivi DROP eleve');
        $this->addSql('ALTER TABLE suivi DROP plan_de_travail');
        $this->addSql('ALTER TABLE suivi ADD CONSTRAINT fk_2ebcca8fa6cc7b2 FOREIGN KEY (eleve_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE suivi ADD CONSTRAINT fk_2ebcca8f99fcce5c FOREIGN KEY (plan_de_travail_id) REFERENCES plan_de_travail (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_2ebcca8f99fcce5c ON suivi (plan_de_travail_id)');
        $this->addSql('CREATE INDEX idx_2ebcca8fa6cc7b2 ON suivi (eleve_id)');
    }
}
