<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523004532 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE livre ALTER auteur DROP NOT NULL');
        $this->addSql('ALTER TABLE note ADD livre_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note ADD utilisateur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA1437D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE note ADD CONSTRAINT FK_CFBDFA14FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_CFBDFA1437D925CB ON note (livre_id)');
        $this->addSql('CREATE INDEX IDX_CFBDFA14FB88E14F ON note (utilisateur_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE livre ALTER auteur SET NOT NULL');
        $this->addSql('ALTER TABLE note DROP CONSTRAINT FK_CFBDFA1437D925CB');
        $this->addSql('ALTER TABLE note DROP CONSTRAINT FK_CFBDFA14FB88E14F');
        $this->addSql('DROP INDEX IDX_CFBDFA1437D925CB');
        $this->addSql('DROP INDEX IDX_CFBDFA14FB88E14F');
        $this->addSql('ALTER TABLE note DROP livre_id');
        $this->addSql('ALTER TABLE note DROP utilisateur_id');
    }
}
