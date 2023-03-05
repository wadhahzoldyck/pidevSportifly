<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230304171241 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE stars DROP FOREIGN KEY FK_11DC02C6782F39A');
        $this->addSql('ALTER TABLE stars DROP FOREIGN KEY FK_11DC02C286E79CC');
        $this->addSql('DROP TABLE stars');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE stars (id INT AUTO_INCREMENT NOT NULL, u_id_id INT DEFAULT NULL, offre_id_id INT DEFAULT NULL, rate_index INT DEFAULT NULL, INDEX IDX_11DC02C286E79CC (offre_id_id), INDEX IDX_11DC02C6782F39A (u_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE stars ADD CONSTRAINT FK_11DC02C6782F39A FOREIGN KEY (u_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE stars ADD CONSTRAINT FK_11DC02C286E79CC FOREIGN KEY (offre_id_id) REFERENCES offre (id)');
    }
}
