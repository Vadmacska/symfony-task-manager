<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250607223802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE task (id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid)', parent_id BINARY(16) DEFAULT NULL COMMENT '(DC2Type:uuid)', user_id BINARY(16) NOT NULL COMMENT '(DC2Type:uuid)', title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, deadline DATETIME DEFAULT NULL, status VARCHAR(20) NOT NULL, INDEX IDX_527EDB25727ACA70 (parent_id), INDEX IDX_527EDB25A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE task ADD CONSTRAINT FK_527EDB25727ACA70 FOREIGN KEY (parent_id) REFERENCES task (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE task ADD CONSTRAINT FK_527EDB25A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE task DROP FOREIGN KEY FK_527EDB25727ACA70
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE task DROP FOREIGN KEY FK_527EDB25A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE task
        SQL);
    }
}
