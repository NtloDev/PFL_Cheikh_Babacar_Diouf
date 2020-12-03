<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201201102347 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE groupe_de_tags (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag_groupe_de_tags (tag_id INT NOT NULL, groupe_de_tags_id INT NOT NULL, INDEX IDX_16FAE6DBBAD26311 (tag_id), INDEX IDX_16FAE6DB98E48EB (groupe_de_tags_id), PRIMARY KEY(tag_id, groupe_de_tags_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE tag_groupe_de_tags ADD CONSTRAINT FK_16FAE6DBBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tag_groupe_de_tags ADD CONSTRAINT FK_16FAE6DB98E48EB FOREIGN KEY (groupe_de_tags_id) REFERENCES groupe_de_tags (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tag_groupe_de_tags DROP FOREIGN KEY FK_16FAE6DB98E48EB');
        $this->addSql('ALTER TABLE tag_groupe_de_tags DROP FOREIGN KEY FK_16FAE6DBBAD26311');
        $this->addSql('DROP TABLE groupe_de_tags');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_groupe_de_tags');
    }
}
