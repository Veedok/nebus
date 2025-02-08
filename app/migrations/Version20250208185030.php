<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250208185030 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE organization (id SERIAL NOT NULL, address_id INT NOT NULL, tname VARCHAR(150) NOT NULL, phones JSON DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C1EE637CF5B7AF75 ON organization (address_id)');
        $this->addSql('CREATE TABLE organization_activity (organization_id INT NOT NULL, activity_id INT NOT NULL, PRIMARY KEY(organization_id, activity_id))');
        $this->addSql('CREATE INDEX IDX_436CCBF832C8A3DE ON organization_activity (organization_id)');
        $this->addSql('CREATE INDEX IDX_436CCBF881C06096 ON organization_activity (activity_id)');
        $this->addSql('ALTER TABLE organization ADD CONSTRAINT FK_C1EE637CF5B7AF75 FOREIGN KEY (address_id) REFERENCES building (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE organization_activity ADD CONSTRAINT FK_436CCBF832C8A3DE FOREIGN KEY (organization_id) REFERENCES organization (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE organization_activity ADD CONSTRAINT FK_436CCBF881C06096 FOREIGN KEY (activity_id) REFERENCES activity (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE organization DROP CONSTRAINT FK_C1EE637CF5B7AF75');
        $this->addSql('ALTER TABLE organization_activity DROP CONSTRAINT FK_436CCBF832C8A3DE');
        $this->addSql('ALTER TABLE organization_activity DROP CONSTRAINT FK_436CCBF881C06096');
        $this->addSql('DROP TABLE organization');
        $this->addSql('DROP TABLE organization_activity');
    }
}
