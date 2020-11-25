<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201123123630 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE promo_profil_de_sortie (promo_id INT NOT NULL, profil_de_sortie_id INT NOT NULL, INDEX IDX_7E36E4E5D0C07AFF (promo_id), INDEX IDX_7E36E4E565E0C4D3 (profil_de_sortie_id), PRIMARY KEY(promo_id, profil_de_sortie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE promo_profil_de_sortie ADD CONSTRAINT FK_7E36E4E5D0C07AFF FOREIGN KEY (promo_id) REFERENCES promo (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE promo_profil_de_sortie ADD CONSTRAINT FK_7E36E4E565E0C4D3 FOREIGN KEY (profil_de_sortie_id) REFERENCES profil_de_sortie (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profil_de_sortie ADD archive TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE promo_profil_de_sortie');
        $this->addSql('ALTER TABLE profil_de_sortie DROP archive');
    }
}
