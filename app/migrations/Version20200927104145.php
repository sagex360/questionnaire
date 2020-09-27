<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200927104145 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answer (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', question_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', form_response_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', answer VARCHAR(255) NOT NULL, INDEX IDX_DADD4A251E27F6BF (question_id), INDEX IDX_DADD4A25C98B851 (form_response_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE form_response (id CHAR(36) NOT NULL COMMENT \'(DC2Type:guid)\', form_id CHAR(36) DEFAULT NULL COMMENT \'(DC2Type:guid)\', INDEX IDX_8F418EBF5FF69B7D (form_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A251E27F6BF FOREIGN KEY (question_id) REFERENCES form_question (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE answer ADD CONSTRAINT FK_DADD4A25C98B851 FOREIGN KEY (form_response_id) REFERENCES form_response (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE form_response ADD CONSTRAINT FK_8F418EBF5FF69B7D FOREIGN KEY (form_id) REFERENCES form (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer DROP FOREIGN KEY FK_DADD4A25C98B851');
        $this->addSql('DROP TABLE answer');
        $this->addSql('DROP TABLE form_response');
    }
}
