<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201119090937 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE poll_response (id CHAR(36) NOT NULL --(DC2Type:uuid)
        , poll_id CHAR(36) NOT NULL --(DC2Type:uuid)
        , content VARCHAR(255) NOT NULL, score INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_88E1734B3C947C0F ON poll_response (poll_id)');
        $this->addSql('DROP TABLE question');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE question (id CHAR(36) NOT NULL COLLATE BINARY --(DC2Type:uuid)
        , poll_id CHAR(36) NOT NULL COLLATE BINARY --(DC2Type:uuid)
        , content VARCHAR(255) NOT NULL COLLATE BINARY, score INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B6F7494E3C947C0F ON question (poll_id)');
        $this->addSql('DROP TABLE poll_response');
    }
}
