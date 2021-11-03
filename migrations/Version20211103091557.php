<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211103091557 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task ADD user_task_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE task ADD last_modified TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25D5BB1F8C FOREIGN KEY (user_task_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_527EDB25D5BB1F8C ON task (user_task_id)');
        $this->addSql('ALTER TABLE "user" ADD validated BOOLEAN DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD nbr_of_tasks INT DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD last_connexion TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT FK_527EDB25D5BB1F8C');
        $this->addSql('DROP INDEX IDX_527EDB25D5BB1F8C');
        $this->addSql('ALTER TABLE task DROP user_task_id');
        $this->addSql('ALTER TABLE task DROP last_modified');
        $this->addSql('ALTER TABLE "user" DROP validated');
        $this->addSql('ALTER TABLE "user" DROP nbr_of_tasks');
        $this->addSql('ALTER TABLE "user" DROP created_at');
        $this->addSql('ALTER TABLE "user" DROP last_connexion');
    }
}
