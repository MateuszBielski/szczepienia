<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190303151413 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE choroba (id INT AUTO_INCREMENT NOT NULL, nazwa VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE szczepionka (id INT AUTO_INCREMENT NOT NULL, czy_zywa TINYINT(1) NOT NULL, czy_obowiazkowa TINYINT(1) NOT NULL, zastepuje_szczepionke INT DEFAULT NULL, wiek_min INT NOT NULL, wiek_max INT NOT NULL, nazwa VARCHAR(255) NOT NULL, producent VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE szczep_ktore_choroby (id INT AUTO_INCREMENT NOT NULL, id_szczepionka_id INT NOT NULL, id_choroba_id INT NOT NULL, INDEX IDX_D94B14BBA88D33D (id_szczepionka_id), INDEX IDX_D94B14BBE99D129D (id_choroba_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE szczep_ktore_choroby ADD CONSTRAINT FK_D94B14BBA88D33D FOREIGN KEY (id_szczepionka_id) REFERENCES szczepionka (id)');
        $this->addSql('ALTER TABLE szczep_ktore_choroby ADD CONSTRAINT FK_D94B14BBE99D129D FOREIGN KEY (id_choroba_id) REFERENCES choroba (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE szczep_ktore_choroby DROP FOREIGN KEY FK_D94B14BBE99D129D');
        $this->addSql('ALTER TABLE szczep_ktore_choroby DROP FOREIGN KEY FK_D94B14BBA88D33D');
        $this->addSql('DROP TABLE choroba');
        $this->addSql('DROP TABLE szczepionka');
        $this->addSql('DROP TABLE szczep_ktore_choroby');
    }
}
