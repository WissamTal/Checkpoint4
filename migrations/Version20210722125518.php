<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210722125518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE language (id INT AUTO_INCREMENT NOT NULL, language_name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE language_repos (language_id INT NOT NULL, repos_id INT NOT NULL, INDEX IDX_4908786C82F1BAF4 (language_id), INDEX IDX_4908786CA213D4CB (repos_id), PRIMARY KEY(language_id, repos_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repo_state (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE repos (id INT AUTO_INCREMENT NOT NULL, repo_state_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, url VARCHAR(255) NOT NULL, date VARCHAR(255) NOT NULL, github_id INT NOT NULL, INDEX IDX_36507C3D76F2F454 (repo_state_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE language_repos ADD CONSTRAINT FK_4908786C82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE language_repos ADD CONSTRAINT FK_4908786CA213D4CB FOREIGN KEY (repos_id) REFERENCES repos (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE repos ADD CONSTRAINT FK_36507C3D76F2F454 FOREIGN KEY (repo_state_id) REFERENCES repo_state (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE language_repos DROP FOREIGN KEY FK_4908786C82F1BAF4');
        $this->addSql('ALTER TABLE repos DROP FOREIGN KEY FK_36507C3D76F2F454');
        $this->addSql('ALTER TABLE language_repos DROP FOREIGN KEY FK_4908786CA213D4CB');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE language_repos');
        $this->addSql('DROP TABLE repo_state');
        $this->addSql('DROP TABLE repos');
        $this->addSql('DROP TABLE user');
    }
}
