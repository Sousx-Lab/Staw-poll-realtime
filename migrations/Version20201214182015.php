<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201214182015 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_88E1734B3C947C0F');
        $this->addSql('CREATE TEMPORARY TABLE __temp__poll_response AS SELECT id, poll_id, content, score FROM poll_response');
        $this->addSql('DROP TABLE poll_response');
        $this->addSql('CREATE TABLE poll_response (id CHAR(36) NOT NULL COLLATE BINARY --(DC2Type:uuid)
        , poll_id CHAR(36) NOT NULL COLLATE BINARY --(DC2Type:uuid)
        , content VARCHAR(255) NOT NULL COLLATE BINARY, score INTEGER NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_88E1734B3C947C0F FOREIGN KEY (poll_id) REFERENCES poll (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO poll_response (id, poll_id, content, score) SELECT id, poll_id, content, score FROM __temp__poll_response');
        $this->addSql('DROP TABLE __temp__poll_response');
        $this->addSql('CREATE INDEX IDX_88E1734B3C947C0F ON poll_response (poll_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_88E1734B3C947C0F');
        $this->addSql('CREATE TEMPORARY TABLE __temp__poll_response AS SELECT id, poll_id, content, score FROM poll_response');
        $this->addSql('DROP TABLE poll_response');
        $this->addSql('CREATE TABLE poll_response (id CHAR(36) NOT NULL --(DC2Type:uuid)
        , poll_id CHAR(36) NOT NULL --(DC2Type:uuid)
        , content VARCHAR(255) NOT NULL, score INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO poll_response (id, poll_id, content, score) SELECT id, poll_id, content, score FROM __temp__poll_response');
        $this->addSql('DROP TABLE __temp__poll_response');
        $this->addSql('CREATE INDEX IDX_88E1734B3C947C0F ON poll_response (poll_id)');
    }
}
