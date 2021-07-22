<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210721213914 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE modop (id INT AUTO_INCREMENT NOT NULL, step INT NOT NULL, title VARCHAR(255) NOT NULL, action VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE modop_techno (modop_id INT NOT NULL, techno_id INT NOT NULL, INDEX IDX_A45A64B9290A4761 (modop_id), INDEX IDX_A45A64B951F3C1BC (techno_id), PRIMARY KEY(modop_id, techno_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE techno (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE modop_techno ADD CONSTRAINT FK_A45A64B9290A4761 FOREIGN KEY (modop_id) REFERENCES modop (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE modop_techno ADD CONSTRAINT FK_A45A64B951F3C1BC FOREIGN KEY (techno_id) REFERENCES techno (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE modop_techno DROP FOREIGN KEY FK_A45A64B9290A4761');
        $this->addSql('ALTER TABLE modop_techno DROP FOREIGN KEY FK_A45A64B951F3C1BC');
        $this->addSql('DROP TABLE modop');
        $this->addSql('DROP TABLE modop_techno');
        $this->addSql('DROP TABLE techno');
    }
}
