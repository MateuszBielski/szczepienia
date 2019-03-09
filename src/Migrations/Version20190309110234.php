<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190309110234 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE grupa_uzytkownik (grupa_id INT NOT NULL, uzytkownik_id INT NOT NULL, INDEX IDX_772A8D937C5C4730 (grupa_id), INDEX IDX_772A8D9331D6FDE9 (uzytkownik_id), PRIMARY KEY(grupa_id, uzytkownik_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE grupa_uzytkownik ADD CONSTRAINT FK_772A8D937C5C4730 FOREIGN KEY (grupa_id) REFERENCES grupa (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE grupa_uzytkownik ADD CONSTRAINT FK_772A8D9331D6FDE9 FOREIGN KEY (uzytkownik_id) REFERENCES uzytkownik (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE grupa_uzytkownik');
    }
}
