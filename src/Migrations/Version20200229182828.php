<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200229182828 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE jardin (id INT AUTO_INCREMENT NOT NULL, name_parc_garden VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, zip_code INT NOT NULL, state TINYINT(1) NOT NULL, type_garden_parc VARCHAR(255) NOT NULL, animaux_accept TINYINT(1) DEFAULT NULL, descriptive VARCHAR(500) DEFAULT NULL, city VARCHAR(255) NOT NULL, name_owner VARCHAR(255) DEFAULT NULL, phone VARCHAR(30) DEFAULT NULL, fax VARCHAR(30) DEFAULT NULL, email_adress VARCHAR(30) DEFAULT NULL, area INT DEFAULT NULL, date_time VARCHAR(500) DEFAULT NULL, price INT DEFAULT NULL, average_duration_visit VARCHAR(255) DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, web_site VARCHAR(30) DEFAULT NULL, facebook VARCHAR(30) DEFAULT NULL, remarkable_label TINYINT(1) DEFAULT NULL, disability_accessibility VARCHAR(255) DEFAULT NULL, type_visit VARCHAR(255) DEFAULT NULL, historical VARCHAR(500) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE jardin');
    }
}
