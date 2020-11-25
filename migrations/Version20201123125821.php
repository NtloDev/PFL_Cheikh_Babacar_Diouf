<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201123125821 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE niveau_devaluation (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, actions VARCHAR(255) NOT NULL, criteres VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE niveau_devaluation_competence (niveau_devaluation_id INT NOT NULL, competence_id INT NOT NULL, INDEX IDX_B56A635947D7A72 (niveau_devaluation_id), INDEX IDX_B56A63515761DAB (competence_id), PRIMARY KEY(niveau_devaluation_id, competence_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE niveau_devaluation_competence ADD CONSTRAINT FK_B56A635947D7A72 FOREIGN KEY (niveau_devaluation_id) REFERENCES niveau_devaluation (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE niveau_devaluation_competence ADD CONSTRAINT FK_B56A63515761DAB FOREIGN KEY (competence_id) REFERENCES competence (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE niveau_devaluation_competence DROP FOREIGN KEY FK_B56A635947D7A72');
        $this->addSql('DROP TABLE niveau_devaluation');
        $this->addSql('DROP TABLE niveau_devaluation_competence');
    }
}
