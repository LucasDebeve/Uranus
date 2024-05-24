<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240524182136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE assignation_groupe_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE assignation_groupe (id INT NOT NULL, groupe_id INT NOT NULL, eleve_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_71E8E4E77A45358C ON assignation_groupe (groupe_id)');
        $this->addSql('CREATE INDEX IDX_71E8E4E7A6CC7B2 ON assignation_groupe (eleve_id)');
        $this->addSql('ALTER TABLE assignation_groupe ADD CONSTRAINT FK_71E8E4E77A45358C FOREIGN KEY (groupe_id) REFERENCES groupe (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE assignation_groupe ADD CONSTRAINT FK_71E8E4E7A6CC7B2 FOREIGN KEY (eleve_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE assignation_groupe_id_seq CASCADE');
        $this->addSql('ALTER TABLE assignation_groupe DROP CONSTRAINT FK_71E8E4E77A45358C');
        $this->addSql('ALTER TABLE assignation_groupe DROP CONSTRAINT FK_71E8E4E7A6CC7B2');
        $this->addSql('DROP TABLE assignation_groupe');
    }
}
