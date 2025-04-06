<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250404172500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE diagnoses (id INT AUTO_INCREMENT NOT NULL, diagnosis_made_id INT NOT NULL, diagnosis_have_id INT NOT NULL, diagnoses_name VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_D26440314EA7A226 (diagnosis_made_id), INDEX IDX_D26440316BF4963 (diagnosis_have_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doctors (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE patients (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schedule (id INT AUTO_INCREMENT NOT NULL, doctor_be_tuday_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_5A3811FB506FEB1E (doctor_be_tuday_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE treatment (id INT AUTO_INCREMENT NOT NULL, patient_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_98013C316B899279 (patient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE diagnoses ADD CONSTRAINT FK_D26440314EA7A226 FOREIGN KEY (diagnosis_made_id) REFERENCES doctors (id)');
        $this->addSql('ALTER TABLE diagnoses ADD CONSTRAINT FK_D26440316BF4963 FOREIGN KEY (diagnosis_have_id) REFERENCES patients (id)');
        $this->addSql('ALTER TABLE schedule ADD CONSTRAINT FK_5A3811FB506FEB1E FOREIGN KEY (doctor_be_tuday_id) REFERENCES doctors (id)');
        $this->addSql('ALTER TABLE treatment ADD CONSTRAINT FK_98013C316B899279 FOREIGN KEY (patient_id) REFERENCES patients (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE diagnoses DROP FOREIGN KEY FK_D26440314EA7A226');
        $this->addSql('ALTER TABLE diagnoses DROP FOREIGN KEY FK_D26440316BF4963');
        $this->addSql('ALTER TABLE schedule DROP FOREIGN KEY FK_5A3811FB506FEB1E');
        $this->addSql('ALTER TABLE treatment DROP FOREIGN KEY FK_98013C316B899279');
        $this->addSql('DROP TABLE diagnoses');
        $this->addSql('DROP TABLE doctors');
        $this->addSql('DROP TABLE patients');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('DROP TABLE treatment');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
