<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181103222000 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE rlt_buildings_metro (building_id INT NOT NULL, metro_id INT NOT NULL, PRIMARY KEY(building_id, metro_id))');
        $this->addSql('CREATE INDEX IDX_18B1B894D2A7E12 ON rlt_buildings_metro (building_id)');
        $this->addSql('CREATE INDEX IDX_18B1B891EA60E4E ON rlt_buildings_metro (metro_id)');
        $this->addSql('CREATE TABLE rlt_accreditated_buildings (building_id INT NOT NULL, bank_id INT NOT NULL, PRIMARY KEY(building_id, bank_id))');
        $this->addSql('CREATE INDEX IDX_9E6AED5A4D2A7E12 ON rlt_accreditated_buildings (building_id)');
        $this->addSql('CREATE INDEX IDX_9E6AED5A11C8FB41 ON rlt_accreditated_buildings (bank_id)');
        $this->addSql('ALTER TABLE rlt_buildings_metro ADD CONSTRAINT FK_18B1B894D2A7E12 FOREIGN KEY (building_id) REFERENCES rlt_buildings (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rlt_buildings_metro ADD CONSTRAINT FK_18B1B891EA60E4E FOREIGN KEY (metro_id) REFERENCES rlt_metro (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rlt_accreditated_buildings ADD CONSTRAINT FK_9E6AED5A4D2A7E12 FOREIGN KEY (building_id) REFERENCES rlt_buildings (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rlt_accreditated_buildings ADD CONSTRAINT FK_9E6AED5A11C8FB41 FOREIGN KEY (bank_id) REFERENCES rlt_banks (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE rlt_buildings_metro DROP CONSTRAINT FK_18B1B894D2A7E12');
        $this->addSql('ALTER TABLE rlt_accreditated_buildings DROP CONSTRAINT FK_9E6AED5A4D2A7E12');
        $this->addSql('ALTER TABLE rlt_accreditated_buildings DROP CONSTRAINT FK_9E6AED5A11C8FB41');
        $this->addSql('ALTER TABLE rlt_users_user_groups DROP CONSTRAINT FK_29ADB803A76ED395');
        $this->addSql('ALTER TABLE rlt_users_user_groups DROP CONSTRAINT FK_29ADB803FE54D947');
        $this->addSql('ALTER TABLE rlt_buildings_metro DROP CONSTRAINT FK_18B1B891EA60E4E');
        $this->addSql('DROP TABLE rlt_buildings_metro');
        $this->addSql('DROP TABLE rlt_accreditated_buildings');
        $this->addSql('DROP TABLE rlt_users_user_groups');
    }
}
