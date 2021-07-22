<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210722075959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE modop_techno DROP FOREIGN KEY FK_A45A64B9290A4761');
        $this->addSql('ALTER TABLE steps_modop DROP FOREIGN KEY FK_9640B412290A4761');
        $this->addSql('ALTER TABLE steps_modop DROP FOREIGN KEY FK_9640B4121EBBD054');
        $this->addSql('ALTER TABLE modop_techno DROP FOREIGN KEY FK_A45A64B951F3C1BC');
        $this->addSql('DROP TABLE modop');
        $this->addSql('DROP TABLE modop_techno');
        $this->addSql('DROP TABLE steps');
        $this->addSql('DROP TABLE steps_modop');
        $this->addSql('DROP TABLE techno');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE modop (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE modop_techno (modop_id INT NOT NULL, techno_id INT NOT NULL, INDEX IDX_A45A64B9290A4761 (modop_id), INDEX IDX_A45A64B951F3C1BC (techno_id), PRIMARY KEY(modop_id, techno_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE steps (id INT AUTO_INCREMENT NOT NULL, action VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE steps_modop (steps_id INT NOT NULL, modop_id INT NOT NULL, INDEX IDX_9640B4121EBBD054 (steps_id), INDEX IDX_9640B412290A4761 (modop_id), PRIMARY KEY(steps_id, modop_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE techno (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE modop_techno ADD CONSTRAINT FK_A45A64B9290A4761 FOREIGN KEY (modop_id) REFERENCES modop (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE modop_techno ADD CONSTRAINT FK_A45A64B951F3C1BC FOREIGN KEY (techno_id) REFERENCES techno (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE steps_modop ADD CONSTRAINT FK_9640B4121EBBD054 FOREIGN KEY (steps_id) REFERENCES steps (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE steps_modop ADD CONSTRAINT FK_9640B412290A4761 FOREIGN KEY (modop_id) REFERENCES modop (id) ON UPDATE NO ACTION ON DELETE CASCADE');
    }
}
