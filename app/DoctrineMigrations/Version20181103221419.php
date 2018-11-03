<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181103221419 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE rlt_banks (id SERIAL NOT NULL, user_creator INT DEFAULT NULL, user_updater INT DEFAULT NULL, name VARCHAR(255) NOT NULL, external_id SMALLINT NOT NULL, address VARCHAR(255) DEFAULT NULL, phone VARCHAR(255) DEFAULT NULL, site VARCHAR(255) DEFAULT NULL, creation_year SMALLINT DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_37C3C4985E237E06 ON rlt_banks (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_37C3C4989F75D7B0 ON rlt_banks (external_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_37C3C498444F97DD ON rlt_banks (phone)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_37C3C498694309E4 ON rlt_banks (site)');
        $this->addSql('CREATE INDEX IDX_37C3C498E40BF469 ON rlt_banks (user_creator)');
        $this->addSql('CREATE INDEX IDX_37C3C4986A423DAC ON rlt_banks (user_updater)');
        $this->addSql('CREATE INDEX rlt_banks_name_idx ON rlt_banks (name)');
        $this->addSql('ALTER TABLE rlt_banks ADD CONSTRAINT FK_37C3C498E40BF469 FOREIGN KEY (user_creator) REFERENCES rlt_users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rlt_banks ADD CONSTRAINT FK_37C3C4986A423DAC FOREIGN KEY (user_updater) REFERENCES rlt_users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE rlt_banks');
    }
}
