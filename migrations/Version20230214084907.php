<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230214084907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dossier_medical ADD firt_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD analyses VARCHAR(255) DEFAULT NULL, ADD maladies VARCHAR(255) NOT NULL, ADD vaccins VARCHAR(255) NOT NULL, ADD intervention_chirurgicale VARCHAR(255) NOT NULL, ADD date_naissance VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE dossier_medical DROP firt_name, DROP last_name, DROP email, DROP analyses, DROP maladies, DROP vaccins, DROP intervention_chirurgicale, DROP date_naissance');
    }
}
