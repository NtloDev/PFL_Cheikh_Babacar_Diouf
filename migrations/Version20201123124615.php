<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201123124615 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE competence_groupe_de_competences (competence_id INT NOT NULL, groupe_de_competences_id INT NOT NULL, INDEX IDX_796FE57715761DAB (competence_id), INDEX IDX_796FE5778C17E6FF (groupe_de_competences_id), PRIMARY KEY(competence_id, groupe_de_competences_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE competence_groupe_de_competences ADD CONSTRAINT FK_796FE57715761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE competence_groupe_de_competences ADD CONSTRAINT FK_796FE5778C17E6FF FOREIGN KEY (groupe_de_competences_id) REFERENCES groupe_de_competences (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE competence_groupe_de_competences');
    }
}
