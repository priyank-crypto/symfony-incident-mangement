<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241211144954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE incident (id INT AUTO_INCREMENT NOT NULL, reporter_id INT NOT NULL, incident_id VARCHAR(255) NOT NULL, incident_details LONGTEXT DEFAULT NULL, reported_date DATETIME DEFAULT NULL, priority VARCHAR(20) NOT NULL, status VARCHAR(255) DEFAULT \'open\' NOT NULL, UNIQUE INDEX UNIQ_3D03A11A59E53FB9 (incident_id), INDEX IDX_3D03A11AE1CFE6F5 (reporter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(50) NOT NULL, last_name VARCHAR(50) NOT NULL, email VARCHAR(180) NOT NULL, address VARCHAR(255) NOT NULL, country VARCHAR(100) NOT NULL, state VARCHAR(100) NOT NULL, city VARCHAR(100) NOT NULL, pincode VARCHAR(10) NOT NULL, mobile VARCHAR(15) NOT NULL, fax VARCHAR(15) DEFAULT NULL, phone VARCHAR(15) DEFAULT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AE1CFE6F5 FOREIGN KEY (reporter_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AE1CFE6F5');
        $this->addSql('DROP TABLE incident');
        $this->addSql('DROP TABLE user');
    }
}
