<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220828174258 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abscences (id INT AUTO_INCREMENT NOT NULL, session_id INT DEFAULT NULL, eleve_id INT DEFAULT NULL, etat VARCHAR(255) NOT NULL, INDEX IDX_7D0323DD613FECDF (session_id), INDEX IDX_7D0323DDA6CC7B2 (eleve_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classes (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE classes_cours (classes_id INT NOT NULL, cours_id INT NOT NULL, INDEX IDX_57A4FC229E225B24 (classes_id), INDEX IDX_57A4FC227ECF78B0 (cours_id), PRIMARY KEY(classes_id, cours_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commentaires (id INT AUTO_INCREMENT NOT NULL, auteur_id INT DEFAULT NULL, content LONGTEXT NOT NULL, INDEX IDX_D9BEC0C460BB6FE6 (auteur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cours (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sessions (id INT AUTO_INCREMENT NOT NULL, classe_id INT DEFAULT NULL, jour VARCHAR(255) NOT NULL, heure VARCHAR(255) NOT NULL, INDEX IDX_9A609D138F5EA509 (classe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, cours_id INT DEFAULT NULL, classes_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, statut VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D6497ECF78B0 (cours_id), INDEX IDX_8D93D6499E225B24 (classes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE abscences ADD CONSTRAINT FK_7D0323DD613FECDF FOREIGN KEY (session_id) REFERENCES sessions (id)');
        $this->addSql('ALTER TABLE abscences ADD CONSTRAINT FK_7D0323DDA6CC7B2 FOREIGN KEY (eleve_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE classes_cours ADD CONSTRAINT FK_57A4FC229E225B24 FOREIGN KEY (classes_id) REFERENCES classes (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE classes_cours ADD CONSTRAINT FK_57A4FC227ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C460BB6FE6 FOREIGN KEY (auteur_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE sessions ADD CONSTRAINT FK_9A609D138F5EA509 FOREIGN KEY (classe_id) REFERENCES classes (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6497ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE `user` ADD CONSTRAINT FK_8D93D6499E225B24 FOREIGN KEY (classes_id) REFERENCES classes (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abscences DROP FOREIGN KEY FK_7D0323DD613FECDF');
        $this->addSql('ALTER TABLE abscences DROP FOREIGN KEY FK_7D0323DDA6CC7B2');
        $this->addSql('ALTER TABLE classes_cours DROP FOREIGN KEY FK_57A4FC229E225B24');
        $this->addSql('ALTER TABLE classes_cours DROP FOREIGN KEY FK_57A4FC227ECF78B0');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C460BB6FE6');
        $this->addSql('ALTER TABLE sessions DROP FOREIGN KEY FK_9A609D138F5EA509');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6497ECF78B0');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D6499E225B24');
        $this->addSql('DROP TABLE abscences');
        $this->addSql('DROP TABLE classes');
        $this->addSql('DROP TABLE classes_cours');
        $this->addSql('DROP TABLE commentaires');
        $this->addSql('DROP TABLE cours');
        $this->addSql('DROP TABLE sessions');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
