<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241129122133 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE courier (id SERIAL NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE regions (id SERIAL NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE trip (id SERIAL NOT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE courier');
        $this->addSql('DROP TABLE regions');
        $this->addSql('DROP TABLE trip');
    }
}
