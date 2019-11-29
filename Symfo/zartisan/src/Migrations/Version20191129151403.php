<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191129151403 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rate ADD user_pro_id INT NOT NULL');
        $this->addSql('ALTER TABLE rate ADD CONSTRAINT FK_DFEC3F39A6E5FF87 FOREIGN KEY (user_pro_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_DFEC3F39A6E5FF87 ON rate (user_pro_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE rate DROP FOREIGN KEY FK_DFEC3F39A6E5FF87');
        $this->addSql('DROP INDEX IDX_DFEC3F39A6E5FF87 ON rate');
        $this->addSql('ALTER TABLE rate DROP user_pro_id');
    }
}
