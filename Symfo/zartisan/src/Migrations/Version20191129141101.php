<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191129141101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user ADD mail_token VARCHAR(255) DEFAULT NULL, ADD is_confirm_mail TINYINT(1) NOT NULL, ADD is_status TINYINT(1) NOT NULL, ADD firstname VARCHAR(255) DEFAULT NULL, ADD lastname VARCHAR(255) DEFAULT NULL, ADD birthday DATE DEFAULT NULL, ADD company VARCHAR(255) DEFAULT NULL, ADD company_description LONGTEXT DEFAULT NULL, ADD naf VARCHAR(50) DEFAULT NULL, ADD adress_supp VARCHAR(255) DEFAULT NULL, ADD special_distribution VARCHAR(50) DEFAULT NULL, ADD ext_number_way VARCHAR(50) DEFAULT NULL, ADD number_way INT DEFAULT NULL, ADD type_way VARCHAR(50) DEFAULT NULL, ADD way VARCHAR(255) DEFAULT NULL, ADD postal_code VARCHAR(50) DEFAULT NULL, ADD city VARCHAR(255) DEFAULT NULL, ADD phone VARCHAR(50) DEFAULT NULL, ADD is_verified TINYINT(1) NOT NULL, ADD picture VARCHAR(255) DEFAULT NULL, ADD picture_folder JSON DEFAULT NULL, ADD region VARCHAR(255) DEFAULT NULL, ADD average_rate INT DEFAULT NULL, ADD is_reported TINYINT(1) NOT NULL, ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user DROP mail_token, DROP is_confirm_mail, DROP is_status, DROP firstname, DROP lastname, DROP birthday, DROP company, DROP company_description, DROP naf, DROP adress_supp, DROP special_distribution, DROP ext_number_way, DROP number_way, DROP type_way, DROP way, DROP postal_code, DROP city, DROP phone, DROP is_verified, DROP picture, DROP picture_folder, DROP region, DROP average_rate, DROP is_reported, DROP created_at, DROP updated_at');
    }
}
