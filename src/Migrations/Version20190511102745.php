<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190511102745 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE data_format (id INT AUTO_INCREMENT NOT NULL, urodziny DATE DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE schemat ADD substitute_id INT DEFAULT NULL, ADD start_year DATE NOT NULL, ADD end_year DATE NOT NULL');
        $this->addSql('ALTER TABLE schemat ADD CONSTRAINT FK_B7E43119ECAD51 FOREIGN KEY (substitute_id) REFERENCES schemat (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B7E43119ECAD51 ON schemat (substitute_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE data_format');
        $this->addSql('ALTER TABLE schemat DROP FOREIGN KEY FK_B7E43119ECAD51');
        $this->addSql('DROP INDEX UNIQ_B7E43119ECAD51 ON schemat');
        $this->addSql('ALTER TABLE schemat DROP substitute_id, DROP start_year, DROP end_year');
    }
}
