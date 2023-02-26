<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230225211456 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre ADD id_category_id INT DEFAULT NULL, CHANGE date date DATE NOT NULL');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866FA545015 FOREIGN KEY (id_category_id) REFERENCES categorie_activite (id)');
        $this->addSql('CREATE INDEX IDX_AF86866FA545015 ON offre (id_category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866FA545015');
        $this->addSql('DROP INDEX IDX_AF86866FA545015 ON offre');
        $this->addSql('ALTER TABLE offre DROP id_category_id, CHANGE date date DATE DEFAULT NULL');
    }
}
