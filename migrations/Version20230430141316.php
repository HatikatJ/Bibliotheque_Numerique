<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230430141316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livre DROP CONSTRAINT fk_ac634f9960bb6fe6');
        $this->addSql('DROP SEQUENCE auteur_id_seq CASCADE');
        $this->addSql('DROP TABLE auteur');
        $this->addSql('DROP INDEX idx_ac634f9960bb6fe6');
        $this->addSql('ALTER TABLE livre DROP auteur_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE auteur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE auteur (id INT NOT NULL, nom_auteur VARCHAR(255) NOT NULL, nationalite VARCHAR(255) DEFAULT NULL, annee_naissance DATE DEFAULT NULL, description_auteur TEXT DEFAULT NULL, photo_couverture VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE livre ADD auteur_id INT NOT NULL');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT fk_ac634f9960bb6fe6 FOREIGN KEY (auteur_id) REFERENCES auteur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_ac634f9960bb6fe6 ON livre (auteur_id)');
    }
}
