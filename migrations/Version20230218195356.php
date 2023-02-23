<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230218195356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE appointment (id INT AUTO_INCREMENT NOT NULL, doctor_id INT NOT NULL, patient_id INT NOT NULL, time_slot_id INT NOT NULL, date DATE DEFAULT NULL, reason VARCHAR(255) DEFAULT NULL, hour TIME DEFAULT NULL, booking_state VARCHAR(255) DEFAULT NULL, INDEX IDX_FE38F84487F4FB17 (doctor_id), INDEX IDX_FE38F8446B899279 (patient_id), UNIQUE INDEX UNIQ_FE38F844D62B0FA (time_slot_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE article (id INT AUTO_INCREMENT NOT NULL, user_id_id INT NOT NULL, sujet VARCHAR(255) NOT NULL, contenu LONGTEXT NOT NULL, image VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_23A0E669D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE calandar_day (id INT AUTO_INCREMENT NOT NULL, doctor_id INT DEFAULT NULL, date DATE NOT NULL, day_start TIME NOT NULL, day_end TIME NOT NULL, session_duration INT NOT NULL, lunch_break_start TIME DEFAULT NULL, lunch_break_end TIME DEFAULT NULL, total_time_slots INT DEFAULT NULL, INDEX IDX_462D1A2F87F4FB17 (doctor_id), UNIQUE INDEX doctor_date_idx (doctor_id, date), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom_categorie VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaire (id INT AUTO_INCREMENT NOT NULL, article_id INT NOT NULL, user_id_id INT NOT NULL, contenu LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_67F068BC7294869C (article_id), INDEX IDX_67F068BC9D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dossier (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, date_naissance VARCHAR(255) NOT NULL, vaccins VARCHAR(255) NOT NULL, maladies VARCHAR(255) NOT NULL, allérgies VARCHAR(255) NOT NULL, analyses VARCHAR(255) NOT NULL, interventionchirurgicale VARCHAR(255) NOT NULL, dossier_id VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_3D48E0379D86650F (user_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, nom_event VARCHAR(30) NOT NULL, discription_event VARCHAR(255) NOT NULL, image_event VARCHAR(255) NOT NULL, date_debut_event DATE NOT NULL, date_fin_event DATE NOT NULL, adresse_event VARCHAR(255) NOT NULL, status VARCHAR(255) DEFAULT NULL, reserve VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE event_ticket (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, event_id_id INT DEFAULT NULL, matricule_event VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, date_ticket DATE NOT NULL, valide_ticket VARCHAR(255) NOT NULL, prix_ticket VARCHAR(255) NOT NULL, description_ticket VARCHAR(255) DEFAULT NULL, adresse VARCHAR(255) DEFAULT NULL, reserve VARCHAR(255) DEFAULT NULL, INDEX IDX_A539DAF19D86650F (user_id_id), INDEX IDX_A539DAF13E5F2F7B (event_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fiche_consultation (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, traitements VARCHAR(255) NOT NULL, recommendation VARCHAR(255) NOT NULL, spécialité_docteur VARCHAR(255) NOT NULL, date_consultation VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produit (id INT AUTO_INCREMENT NOT NULL, categorie_produit_id INT NOT NULL, nom_produit VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, quantite_produit INT NOT NULL, prix DOUBLE PRECISION NOT NULL, image_produit VARCHAR(255) NOT NULL, marque VARCHAR(255) NOT NULL, INDEX IDX_29A5EC2791FDB457 (categorie_produit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE time_slot (id INT AUTO_INCREMENT NOT NULL, calandar_day_id INT NOT NULL, start_time TIME NOT NULL, end_time TIME NOT NULL, status VARCHAR(255) NOT NULL, reason VARCHAR(255) DEFAULT NULL, note LONGTEXT DEFAULT NULL, index_slot INT DEFAULT NULL, INDEX IDX_1B3294AA0A26205 (calandar_day_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, image VARCHAR(255) DEFAULT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, speciality VARCHAR(255) DEFAULT NULL, licence VARCHAR(255) DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(255) NOT NULL, date_of_birth DATE NOT NULL, status VARCHAR(255) DEFAULT NULL, created_at DATE DEFAULT NULL, gender VARCHAR(255) NOT NULL, last_login VARCHAR(255) DEFAULT NULL, updated_at DATE DEFAULT NULL, extra1_rdv VARCHAR(255) DEFAULT NULL, age VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F84487F4FB17 FOREIGN KEY (doctor_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F8446B899279 FOREIGN KEY (patient_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE appointment ADD CONSTRAINT FK_FE38F844D62B0FA FOREIGN KEY (time_slot_id) REFERENCES time_slot (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E669D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE calandar_day ADD CONSTRAINT FK_462D1A2F87F4FB17 FOREIGN KEY (doctor_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC7294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC9D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE dossier ADD CONSTRAINT FK_3D48E0379D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE event_ticket ADD CONSTRAINT FK_A539DAF19D86650F FOREIGN KEY (user_id_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE event_ticket ADD CONSTRAINT FK_A539DAF13E5F2F7B FOREIGN KEY (event_id_id) REFERENCES event (id)');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC2791FDB457 FOREIGN KEY (categorie_produit_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE time_slot ADD CONSTRAINT FK_1B3294AA0A26205 FOREIGN KEY (calandar_day_id) REFERENCES calandar_day (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F84487F4FB17');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F8446B899279');
        $this->addSql('ALTER TABLE appointment DROP FOREIGN KEY FK_FE38F844D62B0FA');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E669D86650F');
        $this->addSql('ALTER TABLE calandar_day DROP FOREIGN KEY FK_462D1A2F87F4FB17');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC7294869C');
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC9D86650F');
        $this->addSql('ALTER TABLE dossier DROP FOREIGN KEY FK_3D48E0379D86650F');
        $this->addSql('ALTER TABLE event_ticket DROP FOREIGN KEY FK_A539DAF19D86650F');
        $this->addSql('ALTER TABLE event_ticket DROP FOREIGN KEY FK_A539DAF13E5F2F7B');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC2791FDB457');
        $this->addSql('ALTER TABLE time_slot DROP FOREIGN KEY FK_1B3294AA0A26205');
        $this->addSql('DROP TABLE appointment');
        $this->addSql('DROP TABLE article');
        $this->addSql('DROP TABLE calandar_day');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE dossier');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE event_ticket');
        $this->addSql('DROP TABLE fiche_consultation');
        $this->addSql('DROP TABLE produit');
        $this->addSql('DROP TABLE time_slot');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
