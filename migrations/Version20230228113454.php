<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230228113454 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE event DROP FOREIGN KEY FK_3BAE0AA7A76ED395');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F79F37AE5');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B1171F7E88B');
        $this->addSql('ALTER TABLE participant DROP FOREIGN KEY FK_D79F6B11A76ED395');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849551C13BCCF');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE commenter');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE participant');
        $this->addSql('DROP TABLE publication');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('ALTER TABLE activiter CHANGE date_debut date_debut DATETIME NOT NULL, CHANGE date_fin date_fin DATETIME NOT NULL');
        $this->addSql('ALTER TABLE actualite CHANGE date date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE commentaire_act ADD id_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE commentaire_act ADD CONSTRAINT FK_348D924279F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_348D924279F37AE5 ON commentaire_act (id_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, roles LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, lastname VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, diplome VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, experience VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, image VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, reset_token VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_880E0D76E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE commenter (id INT AUTO_INCREMENT NOT NULL, id_pub INT NOT NULL, id_user INT NOT NULL, contenu VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, dt DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, titre VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date DATE NOT NULL, img LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, lieu VARCHAR(30) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_3BAE0AA7A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, id_user_id INT NOT NULL, date DATE DEFAULT NULL, affiche VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prix DOUBLE PRECISION NOT NULL, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_AF86866F79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE participant (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, event_id INT DEFAULT NULL, date_participation DATE NOT NULL, INDEX IDX_D79F6B1171F7E88B (event_id), INDEX IDX_D79F6B11A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE publication (id INT AUTO_INCREMENT NOT NULL, id_user INT NOT NULL, description VARCHAR(500) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, img VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, dt DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, id_offre_id INT NOT NULL, date DATE NOT NULL, INDEX IDX_42C849551C13BCCF (id_offre_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B1171F7E88B FOREIGN KEY (event_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE participant ADD CONSTRAINT FK_D79F6B11A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849551C13BCCF FOREIGN KEY (id_offre_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE activiter CHANGE date_debut date_debut DATE NOT NULL, CHANGE date_fin date_fin DATE NOT NULL');
        $this->addSql('ALTER TABLE actualite CHANGE date date DATE NOT NULL');
        $this->addSql('ALTER TABLE commentaire_act DROP FOREIGN KEY FK_348D924279F37AE5');
        $this->addSql('DROP INDEX IDX_348D924279F37AE5 ON commentaire_act');
        $this->addSql('ALTER TABLE commentaire_act DROP id_user_id');
    }
}
