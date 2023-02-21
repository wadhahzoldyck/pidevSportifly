<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230213150430 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commentaire_act (id INT AUTO_INCREMENT NOT NULL, id_actualite_id INT DEFAULT NULL, contenu LONGTEXT NOT NULL, date DATE NOT NULL, INDEX IDX_348D924281454501 (id_actualite_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commentaire_act ADD CONSTRAINT FK_348D924281454501 FOREIGN KEY (id_actualite_id) REFERENCES actualite (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire_act DROP FOREIGN KEY FK_348D924281454501');
        $this->addSql('DROP TABLE commentaire_act');
    }
}
