<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230212151635 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activiter ADD id_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE activiter ADD CONSTRAINT FK_16C6E2379F37AE5 FOREIGN KEY (id_user_id) REFERENCES utilisateur (id)');
        $this->addSql('CREATE INDEX IDX_16C6E2379F37AE5 ON activiter (id_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE activiter DROP FOREIGN KEY FK_16C6E2379F37AE5');
        $this->addSql('DROP INDEX IDX_16C6E2379F37AE5 ON activiter');
        $this->addSql('ALTER TABLE activiter DROP id_user_id');
    }
}
