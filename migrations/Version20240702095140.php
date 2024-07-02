<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240702095140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE seance ADD date DATE NOT NULL');
        $this->addSql('ALTER TABLE seance ADD time TIME(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('COMMENT ON COLUMN seance.date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN seance.time IS \'(DC2Type:time_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE seance DROP date');
        $this->addSql('ALTER TABLE seance DROP time');
    }
}
