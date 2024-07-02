<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240702091155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE siege_id_seq CASCADE');
        $this->addSql('ALTER TABLE siege_booking DROP CONSTRAINT fk_489b3203bf006e8b');
        $this->addSql('ALTER TABLE siege_booking DROP CONSTRAINT fk_489b32033301c60');
        $this->addSql('DROP TABLE siege_booking');
        $this->addSql('DROP TABLE siege');
        $this->addSql('ALTER TABLE booking ADD siege INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE siege_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE siege_booking (siege_id INT NOT NULL, booking_id INT NOT NULL, PRIMARY KEY(siege_id, booking_id))');
        $this->addSql('CREATE INDEX idx_489b32033301c60 ON siege_booking (booking_id)');
        $this->addSql('CREATE INDEX idx_489b3203bf006e8b ON siege_booking (siege_id)');
        $this->addSql('CREATE TABLE siege (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE siege_booking ADD CONSTRAINT fk_489b3203bf006e8b FOREIGN KEY (siege_id) REFERENCES siege (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE siege_booking ADD CONSTRAINT fk_489b32033301c60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE booking DROP siege');
    }
}
