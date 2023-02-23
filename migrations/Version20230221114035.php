<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230221114035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiche_consultation ADD dossier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE fiche_consultation ADD CONSTRAINT FK_CAD69893611C0C56 FOREIGN KEY (dossier_id) REFERENCES dossier (id)');
        $this->addSql('CREATE INDEX IDX_CAD69893611C0C56 ON fiche_consultation (dossier_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fiche_consultation DROP FOREIGN KEY FK_CAD69893611C0C56');
        $this->addSql('DROP INDEX IDX_CAD69893611C0C56 ON fiche_consultation');
        $this->addSql('ALTER TABLE fiche_consultation DROP dossier_id');
    }
}
