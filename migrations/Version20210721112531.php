<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210721112531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language_repos (language_id INT NOT NULL, repos_id INT NOT NULL, INDEX IDX_4908786C82F1BAF4 (language_id), INDEX IDX_4908786CA213D4CB (repos_id), PRIMARY KEY(language_id, repos_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repos (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, url VARCHAR(255) NOT NULL, date VARCHAR(255) NOT NULL, github_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE language_repos ADD CONSTRAINT FK_4908786C82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE language_repos ADD CONSTRAINT FK_4908786CA213D4CB FOREIGN KEY (repos_id) REFERENCES repos (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE language_repos DROP FOREIGN KEY FK_4908786C82F1BAF4');
        $this->addSql('ALTER TABLE language_repos DROP FOREIGN KEY FK_4908786CA213D4CB');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE language_repos');
        $this->addSql('DROP TABLE repos');
    }
}
