<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240524175512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE groupe_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE groupe (id INT NOT NULL, responsable_id INT DEFAULT NULL, titre VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_4B98C2153C59D72 ON groupe (responsable_id)');
        $this->addSql('ALTER TABLE groupe ADD CONSTRAINT FK_4B98C2153C59D72 FOREIGN KEY (responsable_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE groupe_id_seq CASCADE');
        $this->addSql('ALTER TABLE groupe DROP CONSTRAINT FK_4B98C2153C59D72');
        $this->addSql('DROP TABLE groupe');
    }
}
