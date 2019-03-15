<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190315135159 extends AbstractMigration
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
        $this->addSql('CREATE TABLE szczepionka_choroba (szczepionka_id INT NOT NULL, choroba_id INT NOT NULL, INDEX IDX_DF42606C37EE6E3B (szczepionka_id), INDEX IDX_DF42606C4C17924A (choroba_id), PRIMARY KEY(szczepionka_id, choroba_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE warunek (id INT AUTO_INCREMENT NOT NULL, schemat_id INT DEFAULT NULL, okreslenie VARCHAR(255) DEFAULT NULL, INDEX IDX_285BCF3D2CFF5A50 (schemat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE schemat (id INT AUTO_INCREMENT NOT NULL, szczepionka_id INT NOT NULL, INDEX IDX_B7E43137EE6E3B (szczepionka_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE szczepiacy (id INT AUTO_INCREMENT NOT NULL, nazwisko VARCHAR(255) DEFAULT NULL, imie VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE szczepienie (id INT AUTO_INCREMENT NOT NULL, pacjent_id INT NOT NULL, szczepiacy_id INT NOT NULL, co_podano_id INT NOT NULL, INDEX IDX_348A7FEB2C1FB0D6 (pacjent_id), INDEX IDX_348A7FEBD8EDA42E (szczepiacy_id), INDEX IDX_348A7FEB3654303C (co_podano_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pacjent (id INT AUTO_INCREMENT NOT NULL, nazwisko VARCHAR(255) NOT NULL, imie VARCHAR(255) NOT NULL, pesel INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dawka (id INT AUTO_INCREMENT NOT NULL, schemat_id INT NOT NULL, ktora INT NOT NULL, odstep_min INT NOT NULL, odstep_max INT NOT NULL, INDEX IDX_C4082B812CFF5A50 (schemat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE szczepionka_choroba ADD CONSTRAINT FK_DF42606C37EE6E3B FOREIGN KEY (szczepionka_id) REFERENCES szczepionka (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE szczepionka_choroba ADD CONSTRAINT FK_DF42606C4C17924A FOREIGN KEY (choroba_id) REFERENCES choroba (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE warunek ADD CONSTRAINT FK_285BCF3D2CFF5A50 FOREIGN KEY (schemat_id) REFERENCES schemat (id)');
        $this->addSql('ALTER TABLE schemat ADD CONSTRAINT FK_B7E43137EE6E3B FOREIGN KEY (szczepionka_id) REFERENCES szczepionka (id)');
        $this->addSql('ALTER TABLE szczepienie ADD CONSTRAINT FK_348A7FEB2C1FB0D6 FOREIGN KEY (pacjent_id) REFERENCES pacjent (id)');
        $this->addSql('ALTER TABLE szczepienie ADD CONSTRAINT FK_348A7FEBD8EDA42E FOREIGN KEY (szczepiacy_id) REFERENCES szczepiacy (id)');
        $this->addSql('ALTER TABLE szczepienie ADD CONSTRAINT FK_348A7FEB3654303C FOREIGN KEY (co_podano_id) REFERENCES dawka (id)');
        $this->addSql('ALTER TABLE dawka ADD CONSTRAINT FK_C4082B812CFF5A50 FOREIGN KEY (schemat_id) REFERENCES schemat (id)');
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
        //$this->addSql('DROP INDEX IDX_3734584C75E58537 ON choroba');
        //$this->addSql('ALTER TABLE choroba DROP szczepionka2_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE warunek DROP FOREIGN KEY FK_285BCF3D2CFF5A50');
        $this->addSql('ALTER TABLE dawka DROP FOREIGN KEY FK_C4082B812CFF5A50');
        $this->addSql('ALTER TABLE szczepienie DROP FOREIGN KEY FK_348A7FEBD8EDA42E');
        $this->addSql('ALTER TABLE szczepienie DROP FOREIGN KEY FK_348A7FEB2C1FB0D6');
        $this->addSql('ALTER TABLE szczepienie DROP FOREIGN KEY FK_348A7FEB3654303C');
        $this->addSql('CREATE TABLE grupa (id INT AUTO_INCREMENT NOT NULL, nazwa VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE grupa_uzytkownik (grupa_id INT NOT NULL, uzytkownik_id INT NOT NULL, INDEX IDX_772A8D9331D6FDE9 (uzytkownik_id), INDEX IDX_772A8D937C5C4730 (grupa_id), PRIMARY KEY(grupa_id, uzytkownik_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE nazwa (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE szczep_ktore_choroby (id INT AUTO_INCREMENT NOT NULL, id_szczepionka_id INT NOT NULL, id_choroba_id INT NOT NULL, INDEX IDX_D94B14BBA88D33D (id_szczepionka_id), INDEX IDX_D94B14BBE99D129D (id_choroba_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE szczepionka2 (id INT AUTO_INCREMENT NOT NULL, nazwa VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, producent VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, wiek_min INT NOT NULL, wiek_max INT NOT NULL, czy_obowiazkowa TINYINT(1) NOT NULL, zastepuje INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE task (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE task_tag (task_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_6C0B4F04BAD26311 (tag_id), INDEX IDX_6C0B4F048DB60186 (task_id), PRIMARY KEY(task_id, tag_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE telefon (id INT AUTO_INCREMENT NOT NULL, wlasciciel_id INT NOT NULL, numer INT NOT NULL, INDEX IDX_897DA477EF42C80B (wlasciciel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE uzytkownik (id INT AUTO_INCREMENT NOT NULL, imie VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE grupa_uzytkownik ADD CONSTRAINT FK_772A8D9331D6FDE9 FOREIGN KEY (uzytkownik_id) REFERENCES uzytkownik (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE grupa_uzytkownik ADD CONSTRAINT FK_772A8D937C5C4730 FOREIGN KEY (grupa_id) REFERENCES grupa (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE szczep_ktore_choroby ADD CONSTRAINT FK_D94B14BBA88D33D FOREIGN KEY (id_szczepionka_id) REFERENCES szczepionka (id)');
        $this->addSql('ALTER TABLE szczep_ktore_choroby ADD CONSTRAINT FK_D94B14BBE99D129D FOREIGN KEY (id_choroba_id) REFERENCES choroba (id)');
        $this->addSql('ALTER TABLE task_tag ADD CONSTRAINT FK_6C0B4F048DB60186 FOREIGN KEY (task_id) REFERENCES task (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE task_tag ADD CONSTRAINT FK_6C0B4F04BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE telefon ADD CONSTRAINT FK_897DA477EF42C80B FOREIGN KEY (wlasciciel_id) REFERENCES uzytkownik (id)');
        $this->addSql('DROP TABLE szczepionka_choroba');
        $this->addSql('DROP TABLE warunek');
        $this->addSql('DROP TABLE schemat');
        $this->addSql('DROP TABLE szczepiacy');
        $this->addSql('DROP TABLE szczepienie');
        $this->addSql('DROP TABLE pacjent');
        $this->addSql('DROP TABLE dawka');
        $this->addSql('ALTER TABLE choroba ADD szczepionka2_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE choroba ADD CONSTRAINT FK_3734584C75E58537 FOREIGN KEY (szczepionka2_id) REFERENCES szczepionka2 (id)');
        $this->addSql('CREATE INDEX IDX_3734584C75E58537 ON choroba (szczepionka2_id)');
    }
}
