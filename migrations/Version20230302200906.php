<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230302200906 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE like_act (id INT AUTO_INCREMENT NOT NULL, id_actualite_id INT NOT NULL, id_user_id INT NOT NULL, INDEX IDX_C6A57AD81454501 (id_actualite_id), INDEX IDX_C6A57AD79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE like_act ADD CONSTRAINT FK_C6A57AD81454501 FOREIGN KEY (id_actualite_id) REFERENCES actualite (id)');
        $this->addSql('ALTER TABLE like_act ADD CONSTRAINT FK_C6A57AD79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE actualite DROP likes, DROP dislikes');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE like_act DROP FOREIGN KEY FK_C6A57AD81454501');
        $this->addSql('ALTER TABLE like_act DROP FOREIGN KEY FK_C6A57AD79F37AE5');
        $this->addSql('DROP TABLE like_act');
        $this->addSql('ALTER TABLE actualite ADD likes INT DEFAULT NULL, ADD dislikes INT DEFAULT NULL');
    }
}
