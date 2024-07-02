<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240702090330 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE siege_booking (siege_id INT NOT NULL, booking_id INT NOT NULL, PRIMARY KEY(siege_id, booking_id))');
        $this->addSql('CREATE INDEX IDX_489B3203BF006E8B ON siege_booking (siege_id)');
        $this->addSql('CREATE INDEX IDX_489B32033301C60 ON siege_booking (booking_id)');
        $this->addSql('ALTER TABLE siege_booking ADD CONSTRAINT FK_489B3203BF006E8B FOREIGN KEY (siege_id) REFERENCES siege (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE siege_booking ADD CONSTRAINT FK_489B32033301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE siege_booking DROP CONSTRAINT FK_489B3203BF006E8B');
        $this->addSql('ALTER TABLE siege_booking DROP CONSTRAINT FK_489B32033301C60');
        $this->addSql('DROP TABLE siege_booking');
    }
}
