<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190603124424 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE schemat (id INT AUTO_INCREMENT NOT NULL, podawania_id INT NOT NULL, substitute_id INT DEFAULT NULL, start_year DATE NOT NULL, end_year DATE NOT NULL, INDEX IDX_B7E43138B53C02 (podawania_id), UNIQUE INDEX UNIQ_B7E43119ECAD51 (substitute_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE szczepionka (id INT AUTO_INCREMENT NOT NULL, czy_zywa TINYINT(1) NOT NULL, czy_obowiazkowa TINYINT(1) NOT NULL, zastepuje_szczepionke INT DEFAULT NULL, wiek_min INT NOT NULL, wiek_max INT NOT NULL, nazwa VARCHAR(255) NOT NULL, producent VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE szczepionka_choroba (szczepionka_id INT NOT NULL, choroba_id INT NOT NULL, INDEX IDX_DF42606C37EE6E3B (szczepionka_id), INDEX IDX_DF42606C4C17924A (choroba_id), PRIMARY KEY(szczepionka_id, choroba_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kalendarz_szczepien (id INT AUTO_INCREMENT NOT NULL, pacjent_id INT NOT NULL, UNIQUE INDEX UNIQ_E8873E822C1FB0D6 (pacjent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kalendarz_szczepien_dawka (kalendarz_szczepien_id INT NOT NULL, dawka_id INT NOT NULL, INDEX IDX_D4267BB3B6E907C8 (kalendarz_szczepien_id), INDEX IDX_D4267BB3FE1DC118 (dawka_id), PRIMARY KEY(kalendarz_szczepien_id, dawka_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE osoba (id INT AUTO_INCREMENT NOT NULL, imie VARCHAR(255) NOT NULL, nazwisko VARCHAR(255) NOT NULL, discriminator VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE szczepiacy (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE choroba (id INT AUTO_INCREMENT NOT NULL, nazwa VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE szczepienie (id INT AUTO_INCREMENT NOT NULL, pacjent_id INT NOT NULL, szczepiacy_id INT NOT NULL, co_podano_id INT NOT NULL, data_zabiegu DATE NOT NULL, INDEX IDX_348A7FEB2C1FB0D6 (pacjent_id), INDEX IDX_348A7FEBD8EDA42E (szczepiacy_id), INDEX IDX_348A7FEB3654303C (co_podano_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE warunek (id INT AUTO_INCREMENT NOT NULL, schemat_id INT DEFAULT NULL, okreslenie VARCHAR(255) DEFAULT NULL, INDEX IDX_285BCF3D2CFF5A50 (schemat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pacjent (id INT NOT NULL, pesel VARCHAR(11) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dawka (id INT AUTO_INCREMENT NOT NULL, schemat_id INT NOT NULL, ktora INT NOT NULL, wiek_podania_min VARCHAR(255) DEFAULT NULL COMMENT \'(DC2Type:dateinterval)\', wiek_podania_zglos_opoznienie VARCHAR(255) DEFAULT NULL COMMENT \'(DC2Type:dateinterval)\', wiek_podania_max VARCHAR(255) DEFAULT NULL COMMENT \'(DC2Type:dateinterval)\', odstep_min_interval VARCHAR(255) NOT NULL COMMENT \'(DC2Type:dateinterval)\', odstep_max_interval VARCHAR(255) NOT NULL COMMENT \'(DC2Type:dateinterval)\', INDEX IDX_C4082B812CFF5A50 (schemat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE schemat ADD CONSTRAINT FK_B7E43138B53C02 FOREIGN KEY (podawania_id) REFERENCES szczepionka (id)');
        $this->addSql('ALTER TABLE schemat ADD CONSTRAINT FK_B7E43119ECAD51 FOREIGN KEY (substitute_id) REFERENCES schemat (id)');
        $this->addSql('ALTER TABLE szczepionka_choroba ADD CONSTRAINT FK_DF42606C37EE6E3B FOREIGN KEY (szczepionka_id) REFERENCES szczepionka (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE szczepionka_choroba ADD CONSTRAINT FK_DF42606C4C17924A FOREIGN KEY (choroba_id) REFERENCES choroba (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE kalendarz_szczepien ADD CONSTRAINT FK_E8873E822C1FB0D6 FOREIGN KEY (pacjent_id) REFERENCES pacjent (id)');
        $this->addSql('ALTER TABLE kalendarz_szczepien_dawka ADD CONSTRAINT FK_D4267BB3B6E907C8 FOREIGN KEY (kalendarz_szczepien_id) REFERENCES kalendarz_szczepien (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE kalendarz_szczepien_dawka ADD CONSTRAINT FK_D4267BB3FE1DC118 FOREIGN KEY (dawka_id) REFERENCES dawka (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE szczepiacy ADD CONSTRAINT FK_44DCA1DFBF396750 FOREIGN KEY (id) REFERENCES osoba (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE szczepienie ADD CONSTRAINT FK_348A7FEB2C1FB0D6 FOREIGN KEY (pacjent_id) REFERENCES pacjent (id)');
        $this->addSql('ALTER TABLE szczepienie ADD CONSTRAINT FK_348A7FEBD8EDA42E FOREIGN KEY (szczepiacy_id) REFERENCES szczepiacy (id)');
        $this->addSql('ALTER TABLE szczepienie ADD CONSTRAINT FK_348A7FEB3654303C FOREIGN KEY (co_podano_id) REFERENCES dawka (id)');
        $this->addSql('ALTER TABLE warunek ADD CONSTRAINT FK_285BCF3D2CFF5A50 FOREIGN KEY (schemat_id) REFERENCES schemat (id)');
        $this->addSql('ALTER TABLE pacjent ADD CONSTRAINT FK_DAAF3397BF396750 FOREIGN KEY (id) REFERENCES osoba (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dawka ADD CONSTRAINT FK_C4082B812CFF5A50 FOREIGN KEY (schemat_id) REFERENCES schemat (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE schemat DROP FOREIGN KEY FK_B7E43119ECAD51');
        $this->addSql('ALTER TABLE warunek DROP FOREIGN KEY FK_285BCF3D2CFF5A50');
        $this->addSql('ALTER TABLE dawka DROP FOREIGN KEY FK_C4082B812CFF5A50');
        $this->addSql('ALTER TABLE schemat DROP FOREIGN KEY FK_B7E43138B53C02');
        $this->addSql('ALTER TABLE szczepionka_choroba DROP FOREIGN KEY FK_DF42606C37EE6E3B');
        $this->addSql('ALTER TABLE kalendarz_szczepien_dawka DROP FOREIGN KEY FK_D4267BB3B6E907C8');
        $this->addSql('ALTER TABLE szczepiacy DROP FOREIGN KEY FK_44DCA1DFBF396750');
        $this->addSql('ALTER TABLE pacjent DROP FOREIGN KEY FK_DAAF3397BF396750');
        $this->addSql('ALTER TABLE szczepienie DROP FOREIGN KEY FK_348A7FEBD8EDA42E');
        $this->addSql('ALTER TABLE szczepionka_choroba DROP FOREIGN KEY FK_DF42606C4C17924A');
        $this->addSql('ALTER TABLE kalendarz_szczepien DROP FOREIGN KEY FK_E8873E822C1FB0D6');
        $this->addSql('ALTER TABLE szczepienie DROP FOREIGN KEY FK_348A7FEB2C1FB0D6');
        $this->addSql('ALTER TABLE kalendarz_szczepien_dawka DROP FOREIGN KEY FK_D4267BB3FE1DC118');
        $this->addSql('ALTER TABLE szczepienie DROP FOREIGN KEY FK_348A7FEB3654303C');
        $this->addSql('DROP TABLE schemat');
        $this->addSql('DROP TABLE szczepionka');
        $this->addSql('DROP TABLE szczepionka_choroba');
        $this->addSql('DROP TABLE kalendarz_szczepien');
        $this->addSql('DROP TABLE kalendarz_szczepien_dawka');
        $this->addSql('DROP TABLE osoba');
        $this->addSql('DROP TABLE szczepiacy');
        $this->addSql('DROP TABLE choroba');
        $this->addSql('DROP TABLE szczepienie');
        $this->addSql('DROP TABLE warunek');
        $this->addSql('DROP TABLE pacjent');
        $this->addSql('DROP TABLE dawka');
    }
}
/*
CREATE TABLE schemat (id INT AUTO_INCREMENT NOT NULL, podawania_id INT NOT NULL, substitute_id INT DEFAULT NULL, start_year DATE NOT NULL, end_year DATE NOT NULL, INDEX IDX_B7E43138B53C02 (podawania_id), UNIQUE INDEX UNIQ_B7E43119ECAD51 (substitute_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;
CREATE TABLE szczepionka (id INT AUTO_INCREMENT NOT NULL, czy_zywa TINYINT(1) NOT NULL, czy_obowiazkowa TINYINT(1) NOT NULL, zastepuje_szczepionke INT DEFAULT NULL, wiek_min INT NOT NULL, wiek_max INT NOT NULL, nazwa VARCHAR(255) NOT NULL, producent VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;
CREATE TABLE szczepionka_choroba (szczepionka_id INT NOT NULL, choroba_id INT NOT NULL, INDEX IDX_DF42606C37EE6E3B (szczepionka_id), INDEX IDX_DF42606C4C17924A (choroba_id), PRIMARY KEY(szczepionka_id, choroba_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;
CREATE TABLE kalendarz_szczepien (id INT AUTO_INCREMENT NOT NULL, pacjent_id INT NOT NULL, UNIQUE INDEX UNIQ_E8873E822C1FB0D6 (pacjent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;
CREATE TABLE kalendarz_szczepien_dawka (kalendarz_szczepien_id INT NOT NULL, dawka_id INT NOT NULL, INDEX IDX_D4267BB3B6E907C8 (kalendarz_szczepien_id), INDEX IDX_D4267BB3FE1DC118 (dawka_id), PRIMARY KEY(kalendarz_szczepien_id, dawka_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;
CREATE TABLE osoba (id INT AUTO_INCREMENT NOT NULL, imie VARCHAR(255) NOT NULL, nazwisko VARCHAR(255) NOT NULL, discriminator VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;
CREATE TABLE szczepiacy (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;
CREATE TABLE choroba (id INT AUTO_INCREMENT NOT NULL, nazwa VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;
CREATE TABLE szczepienie (id INT AUTO_INCREMENT NOT NULL, pacjent_id INT NOT NULL, szczepiacy_id INT NOT NULL, co_podano_id INT NOT NULL, data_zabiegu DATE NOT NULL, INDEX IDX_348A7FEB2C1FB0D6 (pacjent_id), INDEX IDX_348A7FEBD8EDA42E (szczepiacy_id), INDEX IDX_348A7FEB3654303C (co_podano_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;
CREATE TABLE warunek (id INT AUTO_INCREMENT NOT NULL, schemat_id INT DEFAULT NULL, okreslenie VARCHAR(255) DEFAULT NULL, INDEX IDX_285BCF3D2CFF5A50 (schemat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;
CREATE TABLE pacjent (id INT NOT NULL, pesel VARCHAR(11) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;
CREATE TABLE dawka (id INT AUTO_INCREMENT NOT NULL, schemat_id INT NOT NULL, ktora INT NOT NULL, wiek_podania_min VARCHAR(255) DEFAULT NULL COMMENT \'(DC2Type:dateinterval)\', wiek_podania_zglos_opoznienie VARCHAR(255) DEFAULT NULL COMMENT \'(DC2Type:dateinterval)\', wiek_podania_max VARCHAR(255) DEFAULT NULL COMMENT \'(DC2Type:dateinterval)\', odstep_min_interval VARCHAR(255) NOT NULL COMMENT \'(DC2Type:dateinterval)\', odstep_max_interval VARCHAR(255) NOT NULL COMMENT \'(DC2Type:dateinterval)\', INDEX IDX_C4082B812CFF5A50 (schemat_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB;
ALTER TABLE schemat ADD CONSTRAINT FK_B7E43138B53C02 FOREIGN KEY (podawania_id) REFERENCES szczepionka (id);
ALTER TABLE schemat ADD CONSTRAINT FK_B7E43119ECAD51 FOREIGN KEY (substitute_id) REFERENCES schemat (id);
ALTER TABLE szczepionka_choroba ADD CONSTRAINT FK_DF42606C37EE6E3B FOREIGN KEY (szczepionka_id) REFERENCES szczepionka (id) ON DELETE CASCADE;
ALTER TABLE szczepionka_choroba ADD CONSTRAINT FK_DF42606C4C17924A FOREIGN KEY (choroba_id) REFERENCES choroba (id) ON DELETE CASCADE;
ALTER TABLE kalendarz_szczepien ADD CONSTRAINT FK_E8873E822C1FB0D6 FOREIGN KEY (pacjent_id) REFERENCES pacjent (id);
ALTER TABLE kalendarz_szczepien_dawka ADD CONSTRAINT FK_D4267BB3B6E907C8 FOREIGN KEY (kalendarz_szczepien_id) REFERENCES kalendarz_szczepien (id) ON DELETE CASCADE;
ALTER TABLE kalendarz_szczepien_dawka ADD CONSTRAINT FK_D4267BB3FE1DC118 FOREIGN KEY (dawka_id) REFERENCES dawka (id) ON DELETE CASCADE;
ALTER TABLE szczepiacy ADD CONSTRAINT FK_44DCA1DFBF396750 FOREIGN KEY (id) REFERENCES osoba (id) ON DELETE CASCADE;
ALTER TABLE szczepienie ADD CONSTRAINT FK_348A7FEB2C1FB0D6 FOREIGN KEY (pacjent_id) REFERENCES pacjent (id);
ALTER TABLE szczepienie ADD CONSTRAINT FK_348A7FEBD8EDA42E FOREIGN KEY (szczepiacy_id) REFERENCES szczepiacy (id);
ALTER TABLE szczepienie ADD CONSTRAINT FK_348A7FEB3654303C FOREIGN KEY (co_podano_id) REFERENCES dawka (id);
ALTER TABLE warunek ADD CONSTRAINT FK_285BCF3D2CFF5A50 FOREIGN KEY (schemat_id) REFERENCES schemat (id);
ALTER TABLE pacjent ADD CONSTRAINT FK_DAAF3397BF396750 FOREIGN KEY (id) REFERENCES osoba (id) ON DELETE CASCADE;
ALTER TABLE dawka ADD CONSTRAINT FK_C4082B812CFF5A50 FOREIGN KEY (schemat_id) REFERENCES schemat (id);
*/