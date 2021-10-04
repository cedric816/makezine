<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211004093242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fanzine (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_1582D0DBA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE module (id INT AUTO_INCREMENT NOT NULL, page_id INT NOT NULL, content LONGTEXT NOT NULL, position INT NOT NULL, type VARCHAR(255) NOT NULL, speeled TINYINT(1) NOT NULL, color VARCHAR(255) NOT NULL, url VARCHAR(255) DEFAULT NULL, scotch TINYINT(1) DEFAULT NULL, INDEX IDX_C242628C4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, fanzine_id INT NOT NULL, position INT NOT NULL, INDEX IDX_140AB620651338E7 (fanzine_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fanzine ADD CONSTRAINT FK_1582D0DBA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE module ADD CONSTRAINT FK_C242628C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620651338E7 FOREIGN KEY (fanzine_id) REFERENCES fanzine (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620651338E7');
        $this->addSql('ALTER TABLE module DROP FOREIGN KEY FK_C242628C4663E4');
        $this->addSql('DROP TABLE fanzine');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE page');
    }
}
