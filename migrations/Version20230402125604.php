<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230402125604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE auteur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE avis_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE commentaire_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE livre_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE note_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE utilisateur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE auteur (id INT NOT NULL, nom_auteur VARCHAR(255) NOT NULL, nationalite VARCHAR(255) DEFAULT NULL, annee_naissance DATE DEFAULT NULL, description_auteur TEXT DEFAULT NULL, photo_couverture VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE avis (id INT NOT NULL, utilisateur_id INT NOT NULL, avis TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8F91ABF0FB88E14F ON avis (utilisateur_id)');
        $this->addSql('CREATE TABLE commentaire (id INT NOT NULL, livre_id INT DEFAULT NULL, utilisateur_id INT NOT NULL, commentaires TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_67F068BC37D925CB ON commentaire (livre_id)');
        $this->addSql('CREATE INDEX IDX_67F068BCFB88E14F ON commentaire (utilisateur_id)');
        $this->addSql('CREATE TABLE livre (id INT NOT NULL, auteur_id INT NOT NULL, titre VARCHAR(255) NOT NULL, date_publication DATE NOT NULL, editeur VARCHAR(255) DEFAULT NULL, genre VARCHAR(255) NOT NULL, image_couverture VARCHAR(255) DEFAULT NULL, description_livre TEXT DEFAULT NULL, fichier VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AC634F9960BB6FE6 ON livre (auteur_id)');
        $this->addSql('CREATE TABLE note (id INT NOT NULL, notes TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE utilisateur (id INT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3E7927C74 ON utilisateur (email)');
        $this->addSql('CREATE TABLE livre_lecteur (utilisateur_id INT NOT NULL, livre_id INT NOT NULL, PRIMARY KEY(utilisateur_id, livre_id))');
        $this->addSql('CREATE INDEX IDX_DCA08D6CFB88E14F ON livre_lecteur (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_DCA08D6C37D925CB ON livre_lecteur (livre_id)');
        $this->addSql('CREATE TABLE livre_enregistreur (utilisateur_id INT NOT NULL, livre_id INT NOT NULL, PRIMARY KEY(utilisateur_id, livre_id))');
        $this->addSql('CREATE INDEX IDX_FA454DE7FB88E14F ON livre_enregistreur (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_FA454DE737D925CB ON livre_enregistreur (livre_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC37D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BCFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE livre ADD CONSTRAINT FK_AC634F9960BB6FE6 FOREIGN KEY (auteur_id) REFERENCES auteur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE livre_lecteur ADD CONSTRAINT FK_DCA08D6CFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE livre_lecteur ADD CONSTRAINT FK_DCA08D6C37D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE livre_enregistreur ADD CONSTRAINT FK_FA454DE7FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE livre_enregistreur ADD CONSTRAINT FK_FA454DE737D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE auteur_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE avis_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE commentaire_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE livre_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE note_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE utilisateur_id_seq CASCADE');
        $this->addSql('ALTER TABLE avis DROP CONSTRAINT FK_8F91ABF0FB88E14F');
        $this->addSql('ALTER TABLE commentaire DROP CONSTRAINT FK_67F068BC37D925CB');
        $this->addSql('ALTER TABLE commentaire DROP CONSTRAINT FK_67F068BCFB88E14F');
        $this->addSql('ALTER TABLE livre DROP CONSTRAINT FK_AC634F9960BB6FE6');
        $this->addSql('ALTER TABLE livre_lecteur DROP CONSTRAINT FK_DCA08D6CFB88E14F');
        $this->addSql('ALTER TABLE livre_lecteur DROP CONSTRAINT FK_DCA08D6C37D925CB');
        $this->addSql('ALTER TABLE livre_enregistreur DROP CONSTRAINT FK_FA454DE7FB88E14F');
        $this->addSql('ALTER TABLE livre_enregistreur DROP CONSTRAINT FK_FA454DE737D925CB');
        $this->addSql('DROP TABLE auteur');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE livre');
        $this->addSql('DROP TABLE note');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE livre_lecteur');
        $this->addSql('DROP TABLE livre_enregistreur');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
