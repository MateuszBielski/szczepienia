<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190313221008 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE telefon (id INT AUTO_INCREMENT NOT NULL, wlasciciel_id INT NOT NULL, numer INT NOT NULL, INDEX IDX_897DA477EF42C80B (wlasciciel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE telefon ADD CONSTRAINT FK_897DA477EF42C80B FOREIGN KEY (wlasciciel_id) REFERENCES uzytkownik (id)');
        $this->addSql('ALTER TABLE uzytkownik DROP nazwisko');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE telefon');
        $this->addSql('ALTER TABLE uzytkownik ADD nazwisko VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
