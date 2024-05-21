<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240521153040 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plan_de_travail ADD auteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE plan_de_travail ADD CONSTRAINT FK_C1FC762E60BB6FE6 FOREIGN KEY (auteur_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_C1FC762E60BB6FE6 ON plan_de_travail (auteur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE plan_de_travail DROP CONSTRAINT FK_C1FC762E60BB6FE6');
        $this->addSql('DROP INDEX IDX_C1FC762E60BB6FE6');
        $this->addSql('ALTER TABLE plan_de_travail DROP auteur_id');
    }
}
