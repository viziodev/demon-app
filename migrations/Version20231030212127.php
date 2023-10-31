<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231030212127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etudiant ADD matricule VARCHAR(20) NOT NULL, ADD tuteur VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE module ADD professeur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id)');
        $this->addSql('CREATE INDEX IDX_C242628BAB22EE9 ON module (professeur_id)');
        $this->addSql('ALTER TABLE professeur ADD grade VARCHAR(25) NOT NULL');
        $this->addSql('ALTER TABLE user ADD nom_complet VARCHAR(50) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE etudiant DROP matricule, DROP tuteur');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628BAB22EE9');
        $this->addSql('DROP INDEX IDX_C242628BAB22EE9 ON module');
        $this->addSql('ALTER TABLE module DROP professeur_id');
        $this->addSql('ALTER TABLE professeur DROP grade');
        $this->addSql('ALTER TABLE user DROP nom_complet');
    }
}
