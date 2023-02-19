<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230216141631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sous_categorie DROP FOREIGN KEY FK_52743D7BB6FBC5ED');
        $this->addSql('DROP INDEX IDX_52743D7BB6FBC5ED ON sous_categorie');
        $this->addSql('ALTER TABLE sous_categorie DROP id_souscat_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sous_categorie ADD id_souscat_id INT NOT NULL');
        $this->addSql('ALTER TABLE sous_categorie ADD CONSTRAINT FK_52743D7BB6FBC5ED FOREIGN KEY (id_souscat_id) REFERENCES categorie (id)');
        $this->addSql('CREATE INDEX IDX_52743D7BB6FBC5ED ON sous_categorie (id_souscat_id)');
    }
}
