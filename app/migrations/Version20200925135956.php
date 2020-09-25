<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200925135956 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE form (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5288FD4F5E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE form_question (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', form_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', question VARCHAR(255) NOT NULL, INDEX IDX_7CDCC0A5FF69B7D (form_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE form_question ADD CONSTRAINT FK_7CDCC0A5FF69B7D FOREIGN KEY (form_id) REFERENCES form (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE form_question DROP FOREIGN KEY FK_7CDCC0A5FF69B7D');
        $this->addSql('DROP TABLE form');
        $this->addSql('DROP TABLE form_question');
    }
}
