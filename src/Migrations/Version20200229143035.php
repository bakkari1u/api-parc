<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200229143035 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE jardin ADD name_parc_garden VARCHAR(255) NOT NULL, ADD address VARCHAR(255) NOT NULL, ADD type_garden_parc VARCHAR(255) NOT NULL, ADD descriptive VARCHAR(500) DEFAULT NULL, ADD city VARCHAR(255) NOT NULL, ADD name_owner VARCHAR(255) DEFAULT NULL, ADD area INT DEFAULT NULL, ADD date_time VARCHAR(500) DEFAULT NULL, ADD price INT DEFAULT NULL, ADD average_duration_visit VARCHAR(255) DEFAULT NULL, ADD disability_accessibility VARCHAR(255) DEFAULT NULL, ADD type_visit VARCHAR(255) DEFAULT NULL, ADD historical VARCHAR(500) DEFAULT NULL, DROP name, DROP adresse, DROP type, DROP description, DROP ville, DROP name_proprietaire, DROP surface, DROP heure, DROP tarif, DROP duree_moyenne, DROP andicape, DROP type_visite, DROP historique, CHANGE code_postale zip_code INT NOT NULL, CHANGE public_prive state TINYINT(1) NOT NULL, CHANGE email email_adress VARCHAR(30) DEFAULT NULL, CHANGE remarquable remarkable_label TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE jardin ADD name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD adresse VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD type VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD description VARCHAR(500) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD ville VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD name_proprietaire VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD surface INT DEFAULT NULL, ADD heure VARCHAR(500) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD tarif INT DEFAULT NULL, ADD duree_moyenne VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD andicape VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD type_visite VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, ADD historique VARCHAR(500) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, DROP name_parc_garden, DROP address, DROP type_garden_parc, DROP descriptive, DROP city, DROP name_owner, DROP area, DROP date_time, DROP price, DROP average_duration_visit, DROP disability_accessibility, DROP type_visit, DROP historical, CHANGE zip_code code_postale INT NOT NULL, CHANGE state public_prive TINYINT(1) NOT NULL, CHANGE email_adress email VARCHAR(30) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE remarkable_label remarquable TINYINT(1) DEFAULT NULL');
    }
}
