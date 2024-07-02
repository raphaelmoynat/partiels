<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240702112342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE seance ALTER date TYPE DATE');
        $this->addSql('ALTER TABLE seance ALTER "time" TYPE TIME(0) WITHOUT TIME ZONE');
        $this->addSql('COMMENT ON COLUMN seance.date IS NULL');
        $this->addSql('COMMENT ON COLUMN seance.time IS NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE seance ALTER date TYPE DATE');
        $this->addSql('ALTER TABLE seance ALTER time TYPE TIME(0) WITHOUT TIME ZONE');
        $this->addSql('COMMENT ON COLUMN seance.date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN seance."time" IS \'(DC2Type:time_immutable)\'');
    }
}
