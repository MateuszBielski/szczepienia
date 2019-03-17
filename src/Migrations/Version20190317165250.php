<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190317165250 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        //$this->addSql('ALTER TABLE grupa_uzytkownik DROP FOREIGN KEY FK_772A8D937C5C4730');
        //$this->addSql('ALTER TABLE choroba DROP FOREIGN KEY FK_3734584C75E58537');
        //$this->addSql('ALTER TABLE task_tag DROP FOREIGN KEY FK_6C0B4F04BAD26311');
        //$this->addSql('ALTER TABLE task_tag DROP FOREIGN KEY FK_6C0B4F048DB60186');
        //$this->addSql('ALTER TABLE grupa_uzytkownik DROP FOREIGN KEY FK_772A8D9331D6FDE9');
        //$this->addSql('ALTER TABLE telefon DROP FOREIGN KEY FK_897DA477EF42C80B');
        //$this->addSql('DROP TABLE bateria');
        //$this->addSql('DROP TABLE grupa');
        //$this->addSql('DROP TABLE grupa_uzytkownik');
        //$this->addSql('DROP TABLE nazwa');
        //$this->addSql('DROP TABLE szczep_ktore_choroby');
        //$this->addSql('DROP TABLE szczepionka2');
        //$this->addSql('DROP TABLE tag');
        //$this->addSql('DROP TABLE task');
        //$this->addSql('DROP TABLE task_tag');
        //$this->addSql('DROP TABLE telefon');
        //$this->addSql('DROP TABLE uzytkownik');
        $this->addSql('ALTER TABLE schemat DROP FOREIGN KEY FK_B7E43137EE6E3B');
        $this->addSql('DROP INDEX IDX_B7E43137EE6E3B ON schemat');
        $this->addSql('ALTER TABLE schemat DROP szczepionka_id');
        //$this->addSql('DROP INDEX IDX_3734584C75E58537 ON choroba');
        //$this->addSql('ALTER TABLE choroba DROP szczepionka2_id');
        
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bateria (id INT AUTO_INCREMENT NOT NULL, napiecie INT DEFAULT NULL, pojemnosc INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE grupa (id INT AUTO_INCREMENT NOT NULL, nazwa VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE grupa_uzytkownik (grupa_id INT NOT NULL, uzytkownik_id INT NOT NULL, INDEX IDX_772A8D937C5C4730 (grupa_id), INDEX IDX_772A8D9331D6FDE9 (uzytkownik_id), PRIMARY KEY(grupa_id, uzytkownik_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nazwa (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE szczep_ktore_choroby (id INT AUTO_INCREMENT NOT NULL, id_szczepionka_id INT NOT NULL, id_choroba_id INT NOT NULL, INDEX IDX_D94B14BBE99D129D (id_choroba_id), INDEX IDX_D94B14BBA88D33D (id_szczepionka_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE szczepionka2 (id INT AUTO_INCREMENT NOT NULL, nazwa VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, producent VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, wiek_min INT NOT NULL, wiek_max INT NOT NULL, czy_obowiazkowa TINYINT(1) NOT NULL, zastepuje INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE task_tag (task_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_6C0B4F048DB60186 (task_id), INDEX IDX_6C0B4F04BAD26311 (tag_id), PRIMARY KEY(task_id, tag_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE telefon (id INT AUTO_INCREMENT NOT NULL, wlasciciel_id INT NOT NULL, numer INT NOT NULL, INDEX IDX_897DA477EF42C80B (wlasciciel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE uzytkownik (id INT AUTO_INCREMENT NOT NULL, imie VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE grupa_uzytkownik ADD CONSTRAINT FK_772A8D9331D6FDE9 FOREIGN KEY (uzytkownik_id) REFERENCES uzytkownik (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE grupa_uzytkownik ADD CONSTRAINT FK_772A8D937C5C4730 FOREIGN KEY (grupa_id) REFERENCES grupa (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE szczep_ktore_choroby ADD CONSTRAINT FK_D94B14BBA88D33D FOREIGN KEY (id_szczepionka_id) REFERENCES szczepionka (id)');
        $this->addSql('ALTER TABLE szczep_ktore_choroby ADD CONSTRAINT FK_D94B14BBE99D129D FOREIGN KEY (id_choroba_id) REFERENCES choroba (id)');
        $this->addSql('ALTER TABLE task_tag ADD CONSTRAINT FK_6C0B4F048DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE task_tag ADD CONSTRAINT FK_6C0B4F04BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE telefon ADD CONSTRAINT FK_897DA477EF42C80B FOREIGN KEY (wlasciciel_id) REFERENCES uzytkownik (id)');
        $this->addSql('ALTER TABLE choroba ADD szczepionka2_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE choroba ADD CONSTRAINT FK_3734584C75E58537 FOREIGN KEY (szczepionka2_id) REFERENCES szczepionka2 (id)');
        $this->addSql('CREATE INDEX IDX_3734584C75E58537 ON choroba (szczepionka2_id)');
        $this->addSql('ALTER TABLE schemat ADD szczepionka_id INT NOT NULL');
        $this->addSql('ALTER TABLE schemat ADD CONSTRAINT FK_B7E43137EE6E3B FOREIGN KEY (szczepionka_id) REFERENCES szczepionka (id)');
        $this->addSql('CREATE INDEX IDX_B7E43137EE6E3B ON schemat (szczepionka_id)');
    }
}
