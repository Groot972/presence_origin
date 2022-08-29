<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220828191254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sessions ADD cours_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sessions ADD CONSTRAINT FK_9A609D137ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id)');
        $this->addSql('CREATE INDEX IDX_9A609D137ECF78B0 ON sessions (cours_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sessions DROP FOREIGN KEY FK_9A609D137ECF78B0');
        $this->addSql('DROP INDEX IDX_9A609D137ECF78B0 ON sessions');
        $this->addSql('ALTER TABLE sessions DROP cours_id');
    }
}
