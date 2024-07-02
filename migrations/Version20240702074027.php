<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240702074027 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP CONSTRAINT fk_e00ceddefb8438d7');
        $this->addSql('DROP INDEX idx_e00ceddefb8438d7');
        $this->addSql('ALTER TABLE booking RENAME COLUMN sseance_id TO seance_id');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEE3797A94 FOREIGN KEY (seance_id) REFERENCES seance (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_E00CEDDEE3797A94 ON booking (seance_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE booking DROP CONSTRAINT FK_E00CEDDEE3797A94');
        $this->addSql('DROP INDEX IDX_E00CEDDEE3797A94');
        $this->addSql('ALTER TABLE booking RENAME COLUMN seance_id TO sseance_id');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT fk_e00ceddefb8438d7 FOREIGN KEY (sseance_id) REFERENCES seance (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_e00ceddefb8438d7 ON booking (sseance_id)');
    }
}
