<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200227220004 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE jardin (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, code_postale INT NOT NULL, public_prive TINYINT(1) NOT NULL, type VARCHAR(255) NOT NULL, animaux_accept TINYINT(1) NOT NULL, description VARCHAR(255) DEFAULT NULL, ville VARCHAR(255) NOT NULL, name_proprietaire VARCHAR(255) DEFAULT NULL, phone VARCHAR(30) DEFAULT NULL, fax VARCHAR(30) DEFAULT NULL, email VARCHAR(30) DEFAULT NULL, surface INT DEFAULT NULL, heure VARCHAR(255) DEFAULT NULL, tarif INT DEFAULT NULL, duree_moyenne VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, web_site VARCHAR(30) DEFAULT NULL, facebook VARCHAR(30) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE jardin');
    }
}
