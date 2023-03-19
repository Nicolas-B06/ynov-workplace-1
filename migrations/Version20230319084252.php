<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230319084252 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE conversation (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, guest_id INTEGER NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_8A8E26E97E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_8A8E26E99A4AA658 FOREIGN KEY (guest_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_8A8E26E97E3C61F9 ON conversation (owner_id)');
        $this->addSql('CREATE INDEX IDX_8A8E26E99A4AA658 ON conversation (guest_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__message AS SELECT id, owner_id, thread_id, content, has_been_edited, created_at, modified_at, rating FROM message');
        $this->addSql('DROP TABLE message');
        $this->addSql('CREATE TABLE message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER DEFAULT NULL, thread_id INTEGER NOT NULL, content CLOB NOT NULL, has_been_edited BOOLEAN NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , modified_at DATETIME DEFAULT NULL, rating INTEGER NOT NULL, CONSTRAINT FK_B6BD307F7E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B6BD307FE2904019 FOREIGN KEY (thread_id) REFERENCES thread (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO message (id, owner_id, thread_id, content, has_been_edited, created_at, modified_at, rating) SELECT id, owner_id, thread_id, content, has_been_edited, created_at, modified_at, rating FROM __temp__message');
        $this->addSql('DROP TABLE __temp__message');
        $this->addSql('CREATE INDEX IDX_B6BD307FE2904019 ON message (thread_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F7E3C61F9 ON message (owner_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__thread AS SELECT id, owner_id, related_group_id, title, slug, content, created_at FROM thread');
        $this->addSql('DROP TABLE thread');
        $this->addSql('CREATE TABLE thread (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, related_group_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content CLOB NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_31204C837E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_31204C8358D797EA FOREIGN KEY (related_group_id) REFERENCES "group" (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO thread (id, owner_id, related_group_id, title, slug, content, created_at) SELECT id, owner_id, related_group_id, title, slug, content, created_at FROM __temp__thread');
        $this->addSql('DROP TABLE __temp__thread');
        $this->addSql('CREATE INDEX IDX_31204C8358D797EA ON thread (related_group_id)');
        $this->addSql('CREATE INDEX IDX_31204C837E3C61F9 ON thread (owner_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, roles, password, nickname FROM user');
        $this->addSql('DROP TABLE user');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, nickname VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO user (id, email, roles, password, nickname) SELECT id, email, roles, password, nickname FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE conversation');
        $this->addSql('CREATE TEMPORARY TABLE __temp__message AS SELECT id, owner_id, thread_id, content, has_been_edited, created_at, modified_at, rating FROM message');
        $this->addSql('DROP TABLE message');
        $this->addSql('CREATE TABLE message (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER DEFAULT NULL, thread_id INTEGER NOT NULL, content CLOB NOT NULL, has_been_edited BOOLEAN NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , modified_at DATETIME DEFAULT NULL, rating INTEGER NOT NULL, CONSTRAINT FK_B6BD307F7E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B6BD307FE2904019 FOREIGN KEY (thread_id) REFERENCES thread (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO message (id, owner_id, thread_id, content, has_been_edited, created_at, modified_at, rating) SELECT id, owner_id, thread_id, content, has_been_edited, created_at, modified_at, rating FROM __temp__message');
        $this->addSql('DROP TABLE __temp__message');
        $this->addSql('CREATE INDEX IDX_B6BD307F7E3C61F9 ON message (owner_id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FE2904019 ON message (thread_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__thread AS SELECT id, owner_id, related_group_id, title, slug, content, created_at FROM thread');
        $this->addSql('DROP TABLE thread');
        $this->addSql('CREATE TABLE thread (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, related_group_id INTEGER DEFAULT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, content CLOB NOT NULL, created_at DATETIME NOT NULL --(DC2Type:datetime_immutable)
        , CONSTRAINT FK_31204C837E3C61F9 FOREIGN KEY (owner_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_31204C8358D797EA FOREIGN KEY (related_group_id) REFERENCES "group" (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO thread (id, owner_id, related_group_id, title, slug, content, created_at) SELECT id, owner_id, related_group_id, title, slug, content, created_at FROM __temp__thread');
        $this->addSql('DROP TABLE __temp__thread');
        $this->addSql('CREATE INDEX IDX_31204C837E3C61F9 ON thread (owner_id)');
        $this->addSql('CREATE INDEX IDX_31204C8358D797EA ON thread (related_group_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__user AS SELECT id, email, password, roles, nickname FROM "user"');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('CREATE TABLE "user" (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , nickname VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO "user" (id, email, password, roles, nickname) SELECT id, email, password, roles, nickname FROM __temp__user');
        $this->addSql('DROP TABLE __temp__user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON "user" (email)');
    }
}
