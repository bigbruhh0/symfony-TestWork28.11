<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241129123809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE trip ADD courier_id INT NOT NULL');
        $this->addSql('ALTER TABLE trip ADD region_id INT NOT NULL');
        $this->addSql('ALTER TABLE trip ADD begin_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE trip ADD end_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53BE3D8151C FOREIGN KEY (courier_id) REFERENCES courier (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53B98260155 FOREIGN KEY (region_id) REFERENCES regions (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_7656F53BE3D8151C ON trip (courier_id)');
        $this->addSql('CREATE INDEX IDX_7656F53B98260155 ON trip (region_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE trip DROP CONSTRAINT FK_7656F53BE3D8151C');
        $this->addSql('ALTER TABLE trip DROP CONSTRAINT FK_7656F53B98260155');
        $this->addSql('DROP INDEX IDX_7656F53BE3D8151C');
        $this->addSql('DROP INDEX IDX_7656F53B98260155');
        $this->addSql('ALTER TABLE trip DROP courier_id');
        $this->addSql('ALTER TABLE trip DROP region_id');
        $this->addSql('ALTER TABLE trip DROP begin_date');
        $this->addSql('ALTER TABLE trip DROP end_date');
    }
}
