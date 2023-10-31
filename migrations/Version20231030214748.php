<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231030214748 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE professeur_module (professeur_id INT NOT NULL, module_id INT NOT NULL, INDEX IDX_BB082478BAB22EE9 (professeur_id), INDEX IDX_BB082478AFC2B591 (module_id), PRIMARY KEY(professeur_id, module_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE professeur_module ADD CONSTRAINT FK_BB082478BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE professeur_module ADD CONSTRAINT FK_BB082478AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628BAB22EE9');
        $this->addSql('DROP INDEX IDX_C242628BAB22EE9 ON module');
        $this->addSql('ALTER TABLE module DROP professeur_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE professeur_module DROP FOREIGN KEY FK_BB082478BAB22EE9');
        $this->addSql('ALTER TABLE professeur_module DROP FOREIGN KEY FK_BB082478AFC2B591');
        $this->addSql('DROP TABLE professeur_module');
        $this->addSql('ALTER TABLE module ADD professeur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628BAB22EE9 FOREIGN KEY (professeur_id) REFERENCES professeur (id)');
        $this->addSql('CREATE INDEX IDX_C242628BAB22EE9 ON module (professeur_id)');
    }
}
