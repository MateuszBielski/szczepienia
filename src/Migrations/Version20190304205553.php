<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190304205553 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE szczepionka2 (id INT AUTO_INCREMENT NOT NULL, nazwa VARCHAR(255) NOT NULL, producent VARCHAR(255) NOT NULL, wiek_min INT NOT NULL, wiek_max INT NOT NULL, czy_obowiazkowa TINYINT(1) NOT NULL, zastepuje INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nazwa (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE choroba ADD szczepionka2_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE choroba ADD CONSTRAINT FK_3734584C75E58537 FOREIGN KEY (szczepionka2_id) REFERENCES szczepionka2 (id)');
        $this->addSql('CREATE INDEX IDX_3734584C75E58537 ON choroba (szczepionka2_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE choroba DROP FOREIGN KEY FK_3734584C75E58537');
        $this->addSql('DROP TABLE szczepionka2');
        $this->addSql('DROP TABLE nazwa');
        $this->addSql('DROP INDEX IDX_3734584C75E58537 ON choroba');
        $this->addSql('ALTER TABLE choroba DROP szczepionka2_id');
    }
}
