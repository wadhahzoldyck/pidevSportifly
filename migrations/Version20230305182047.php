<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230305182047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offer_rating DROP FOREIGN KEY FK_1DC51831C13BCCF');
        $this->addSql('ALTER TABLE offer_rating DROP FOREIGN KEY FK_1DC518379F37AE5');
        $this->addSql('DROP TABLE offer_rating');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE offer_rating (id INT AUTO_INCREMENT NOT NULL, id_offre_id INT DEFAULT NULL, id_user_id INT DEFAULT NULL, note INT DEFAULT NULL, INDEX IDX_1DC51831C13BCCF (id_offre_id), INDEX IDX_1DC518379F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE offer_rating ADD CONSTRAINT FK_1DC51831C13BCCF FOREIGN KEY (id_offre_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE offer_rating ADD CONSTRAINT FK_1DC518379F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
    }
}
