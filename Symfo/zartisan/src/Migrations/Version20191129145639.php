<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191129145639 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE advice ADD user_author_id INT NOT NULL');
        $this->addSql('ALTER TABLE advice ADD CONSTRAINT FK_64820E8DF6957EFF FOREIGN KEY (user_author_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_64820E8DF6957EFF ON advice (user_author_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE advice DROP FOREIGN KEY FK_64820E8DF6957EFF');
        $this->addSql('DROP INDEX IDX_64820E8DF6957EFF ON advice');
        $this->addSql('ALTER TABLE advice DROP user_author_id');
    }
}
