<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210721220608 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE steps (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE steps_modop (steps_id INT NOT NULL, modop_id INT NOT NULL, INDEX IDX_9640B4121EBBD054 (steps_id), INDEX IDX_9640B412290A4761 (modop_id), PRIMARY KEY(steps_id, modop_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE steps_modop ADD CONSTRAINT FK_9640B4121EBBD054 FOREIGN KEY (steps_id) REFERENCES steps (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE steps_modop ADD CONSTRAINT FK_9640B412290A4761 FOREIGN KEY (modop_id) REFERENCES modop (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE modop DROP step');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE steps_modop DROP FOREIGN KEY FK_9640B4121EBBD054');
        $this->addSql('DROP TABLE steps');
        $this->addSql('DROP TABLE steps_modop');
        $this->addSql('ALTER TABLE modop ADD step INT NOT NULL');
    }
}
