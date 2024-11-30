<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241129124212 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE courier_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE trip_id_seq CASCADE');
        $this->addSql('CREATE TABLE couriers (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE trips (id SERIAL NOT NULL, courier_id INT NOT NULL, region_id INT NOT NULL, begin_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_AA7370DAE3D8151C ON trips (courier_id)');
        $this->addSql('CREATE INDEX IDX_AA7370DA98260155 ON trips (region_id)');
        $this->addSql('ALTER TABLE trips ADD CONSTRAINT FK_AA7370DAE3D8151C FOREIGN KEY (courier_id) REFERENCES couriers (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE trips ADD CONSTRAINT FK_AA7370DA98260155 FOREIGN KEY (region_id) REFERENCES regions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE trip DROP CONSTRAINT fk_7656f53be3d8151c');
        $this->addSql('ALTER TABLE trip DROP CONSTRAINT fk_7656f53b98260155');
        $this->addSql('DROP TABLE trip');
        $this->addSql('DROP TABLE courier');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE courier_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE trip_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE trip (id SERIAL NOT NULL, courier_id INT NOT NULL, region_id INT NOT NULL, begin_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX idx_7656f53b98260155 ON trip (region_id)');
        $this->addSql('CREATE INDEX idx_7656f53be3d8151c ON trip (courier_id)');
        $this->addSql('CREATE TABLE courier (id SERIAL NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT fk_7656f53be3d8151c FOREIGN KEY (courier_id) REFERENCES courier (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT fk_7656f53b98260155 FOREIGN KEY (region_id) REFERENCES regions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE trips DROP CONSTRAINT FK_AA7370DAE3D8151C');
        $this->addSql('ALTER TABLE trips DROP CONSTRAINT FK_AA7370DA98260155');
        $this->addSql('DROP TABLE couriers');
        $this->addSql('DROP TABLE trips');
    }
}
