<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190416071139 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE kalendarz_szczepien (id INT AUTO_INCREMENT NOT NULL, pacjent_id INT NOT NULL, UNIQUE INDEX UNIQ_E8873E822C1FB0D6 (pacjent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kalendarz_szczepien_dawka (kalendarz_szczepien_id INT NOT NULL, dawka_id INT NOT NULL, INDEX IDX_D4267BB3B6E907C8 (kalendarz_szczepien_id), INDEX IDX_D4267BB3FE1DC118 (dawka_id), PRIMARY KEY(kalendarz_szczepien_id, dawka_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE kalendarz_szczepien ADD CONSTRAINT FK_E8873E822C1FB0D6 FOREIGN KEY (pacjent_id) REFERENCES pacjent (id)');
        $this->addSql('ALTER TABLE kalendarz_szczepien_dawka ADD CONSTRAINT FK_D4267BB3B6E907C8 FOREIGN KEY (kalendarz_szczepien_id) REFERENCES kalendarz_szczepien (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE kalendarz_szczepien_dawka ADD CONSTRAINT FK_D4267BB3FE1DC118 FOREIGN KEY (dawka_id) REFERENCES dawka (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dawka ADD wiek_podania_min VARCHAR(255) DEFAULT NULL COMMENT \'(DC2Type:dateinterval)\', ADD wiek_podania_zglos_opoznienie VARCHAR(255) DEFAULT NULL COMMENT \'(DC2Type:dateinterval)\', ADD wiek_podania_max VARCHAR(255) DEFAULT NULL COMMENT \'(DC2Type:dateinterval)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE kalendarz_szczepien_dawka DROP FOREIGN KEY FK_D4267BB3B6E907C8');
        $this->addSql('DROP TABLE kalendarz_szczepien');
        $this->addSql('DROP TABLE kalendarz_szczepien_dawka');
        $this->addSql('ALTER TABLE dawka DROP wiek_podania_min, DROP wiek_podania_zglos_opoznienie, DROP wiek_podania_max');
    }
}
