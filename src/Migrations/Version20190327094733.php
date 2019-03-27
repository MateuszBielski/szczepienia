<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190327094733 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE szczepiacy (id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE szczepienie (id INT AUTO_INCREMENT NOT NULL, pacjent_id INT NOT NULL, szczepiacy_id INT NOT NULL, co_podano_id INT NOT NULL, data_zabiegu DATE NOT NULL, INDEX IDX_348A7FEB2C1FB0D6 (pacjent_id), INDEX IDX_348A7FEBD8EDA42E (szczepiacy_id), INDEX IDX_348A7FEB3654303C (co_podano_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE pacjent (id INT NOT NULL, pesel INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE szczepiacy ADD CONSTRAINT FK_44DCA1DFBF396750 FOREIGN KEY (id) REFERENCES osoba (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE szczepienie ADD CONSTRAINT FK_348A7FEB2C1FB0D6 FOREIGN KEY (pacjent_id) REFERENCES pacjent (id)');
        $this->addSql('ALTER TABLE szczepienie ADD CONSTRAINT FK_348A7FEBD8EDA42E FOREIGN KEY (szczepiacy_id) REFERENCES szczepiacy (id)');
        $this->addSql('ALTER TABLE szczepienie ADD CONSTRAINT FK_348A7FEB3654303C FOREIGN KEY (co_podano_id) REFERENCES dawka (id)');
        $this->addSql('ALTER TABLE pacjent ADD CONSTRAINT FK_DAAF3397BF396750 FOREIGN KEY (id) REFERENCES osoba (id) ON DELETE CASCADE');
        $this->addSql('DROP INDEX IDX_3734584C75E58537 ON choroba');
        $this->addSql('ALTER TABLE choroba DROP szczepionka2_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE szczepienie DROP FOREIGN KEY FK_348A7FEBD8EDA42E');
        $this->addSql('ALTER TABLE szczepienie DROP FOREIGN KEY FK_348A7FEB2C1FB0D6');
        $this->addSql('DROP TABLE szczepiacy');
        $this->addSql('DROP TABLE szczepienie');
        $this->addSql('DROP TABLE pacjent');
        $this->addSql('ALTER TABLE choroba ADD szczepionka2_id INT DEFAULT NULL');
        $this->addSql('CREATE INDEX IDX_3734584C75E58537 ON choroba (szczepionka2_id)');
    }
}
