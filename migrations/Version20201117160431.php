<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201117160431 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__poll AS SELECT id, title, created_at FROM poll');
        $this->addSql('DROP TABLE poll');
        $this->addSql('CREATE TABLE poll (id CHAR(36) NOT NULL --(DC2Type:uuid)
        , title VARCHAR(255) NOT NULL COLLATE BINARY, created_at DATETIME NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO poll (id, title, created_at) SELECT id, title, created_at FROM __temp__poll');
        $this->addSql('DROP TABLE __temp__poll');
        $this->addSql('DROP INDEX IDX_B6F7494E3C947C0F');
        $this->addSql('CREATE TEMPORARY TABLE __temp__question AS SELECT id, poll_id, content, score FROM question');
        $this->addSql('DROP TABLE question');
        $this->addSql('CREATE TABLE question (id CHAR(36) NOT NULL --(DC2Type:uuid)
        , poll_id CHAR(36) NOT NULL --(DC2Type:uuid)
        , content VARCHAR(255) NOT NULL COLLATE BINARY, score INTEGER NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_B6F7494E3C947C0F FOREIGN KEY (poll_id) REFERENCES poll (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO question (id, poll_id, content, score) SELECT id, poll_id, content, score FROM __temp__question');
        $this->addSql('DROP TABLE __temp__question');
        $this->addSql('CREATE INDEX IDX_B6F7494E3C947C0F ON question (poll_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__poll AS SELECT id, title, created_at FROM poll');
        $this->addSql('DROP TABLE poll');
        $this->addSql('CREATE TABLE poll (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL)');
        $this->addSql('INSERT INTO poll (id, title, created_at) SELECT id, title, created_at FROM __temp__poll');
        $this->addSql('DROP TABLE __temp__poll');
        $this->addSql('DROP INDEX IDX_B6F7494E3C947C0F');
        $this->addSql('CREATE TEMPORARY TABLE __temp__question AS SELECT id, poll_id, content, score FROM question');
        $this->addSql('DROP TABLE question');
        $this->addSql('CREATE TABLE question (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, content VARCHAR(255) NOT NULL, score INTEGER NOT NULL, poll_id INTEGER NOT NULL)');
        $this->addSql('INSERT INTO question (id, poll_id, content, score) SELECT id, poll_id, content, score FROM __temp__question');
        $this->addSql('DROP TABLE __temp__question');
        $this->addSql('CREATE INDEX IDX_B6F7494E3C947C0F ON question (poll_id)');
    }
}
