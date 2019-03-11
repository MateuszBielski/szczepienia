<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190311071148 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE nazwa (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE szczepionka2 (id INT AUTO_INCREMENT NOT NULL, nazwa VARCHAR(255) NOT NULL, producent VARCHAR(255) NOT NULL, wiek_min INT NOT NULL, wiek_max INT NOT NULL, czy_obowiazkowa TINYINT(1) NOT NULL, zastepuje INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE task_tag (task_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_6C0B4F048DB60186 (task_id), INDEX IDX_6C0B4F04BAD26311 (tag_id), PRIMARY KEY(task_id, tag_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE task_tag ADD CONSTRAINT FK_6C0B4F048DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE task_tag ADD CONSTRAINT FK_6C0B4F04BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE choroba ADD szczepionka2_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE choroba ADD CONSTRAINT FK_3734584C75E58537 FOREIGN KEY (szczepionka2_id) REFERENCES szczepionka2 (id)');
        $this->addSql('CREATE INDEX IDX_3734584C75E58537 ON choroba (szczepionka2_id)');
        $this->addSql('ALTER TABLE grupa ADD nazwa VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE task_tag DROP FOREIGN KEY FK_6C0B4F04BAD26311');
        $this->addSql('ALTER TABLE choroba DROP FOREIGN KEY FK_3734584C75E58537');
        $this->addSql('ALTER TABLE task_tag DROP FOREIGN KEY FK_6C0B4F048DB60186');
        $this->addSql('DROP TABLE nazwa');
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE szczepionka2');
        $this->addSql('DROP TABLE task');
        $this->addSql('DROP TABLE task_tag');
        $this->addSql('DROP INDEX IDX_3734584C75E58537 ON choroba');
        $this->addSql('ALTER TABLE choroba DROP szczepionka2_id');
        $this->addSql('ALTER TABLE grupa DROP nazwa');
    }
}
