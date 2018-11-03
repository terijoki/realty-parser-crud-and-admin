<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181103221831 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE rlt_developers (id SERIAL NOT NULL, user_creator INT DEFAULT NULL, user_updater INT DEFAULT NULL, name VARCHAR(255) NOT NULL, external_id SMALLINT NOT NULL, phone VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, site VARCHAR(255) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, creation_year SMALLINT DEFAULT NULL, logo VARCHAR(255) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6AC2D84F5E237E06 ON rlt_developers (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6AC2D84F9F75D7B0 ON rlt_developers (external_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6AC2D84F444F97DD ON rlt_developers (phone)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6AC2D84FE7927C74 ON rlt_developers (email)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6AC2D84F694309E4 ON rlt_developers (site)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6AC2D84FD4E6F81 ON rlt_developers (address)');
        $this->addSql('CREATE INDEX IDX_6AC2D84FE40BF469 ON rlt_developers (user_creator)');
        $this->addSql('CREATE INDEX IDX_6AC2D84F6A423DAC ON rlt_developers (user_updater)');
        $this->addSql('CREATE INDEX rlt_developers_name_idx ON rlt_developers (name)');
        $this->addSql('ALTER TABLE rlt_developers ADD CONSTRAINT FK_6AC2D84FE40BF469 FOREIGN KEY (user_creator) REFERENCES rlt_users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rlt_developers ADD CONSTRAINT FK_6AC2D84F6A423DAC FOREIGN KEY (user_updater) REFERENCES rlt_users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE rlt_developers');
    }
}
