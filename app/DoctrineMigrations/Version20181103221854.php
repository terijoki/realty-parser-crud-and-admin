<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181103221854 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE rlt_buildings (id SERIAL NOT NULL, distinct_id INT NOT NULL, developer_id INT NOT NULL, user_creator INT DEFAULT NULL, user_updater INT DEFAULT NULL, name VARCHAR(255) NOT NULL, external_id INT NOT NULL, class SMALLINT DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, build_type SMALLINT DEFAULT NULL, floors VARCHAR(255) DEFAULT NULL, contract_type BOOLEAN DEFAULT NULL, flat_count VARCHAR(255) DEFAULT NULL, permission BOOLEAN DEFAULT \'false\' NOT NULL, build_date JSONB DEFAULT \'[]\' NOT NULL, facing SMALLINT DEFAULT NULL, payment_type BOOLEAN DEFAULT NULL, images JSONB DEFAULT \'[]\' NOT NULL, description VARCHAR(255) DEFAULT NULL, our_opinition VARCHAR(255) DEFAULT NULL, status BOOLEAN NOT NULL, parking VARCHAR(255) DEFAULT NULL, external_updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, price VARCHAR(255) DEFAULT NULL, price_per_m2 VARCHAR(255) DEFAULT NULL, flats JSONB DEFAULT \'[]\' NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8238F0795E237E06 ON rlt_buildings (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8238F0799F75D7B0 ON rlt_buildings (external_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8238F079D4E6F81 ON rlt_buildings (address)');
        $this->addSql('CREATE INDEX IDX_8238F079E40BF469 ON rlt_buildings (user_creator)');
        $this->addSql('CREATE INDEX IDX_8238F0796A423DAC ON rlt_buildings (user_updater)');
        $this->addSql('CREATE INDEX rlt_buildings_name_idx ON rlt_buildings (name)');
        $this->addSql('CREATE INDEX rlt_buildings_distinct_idx ON rlt_buildings (distinct_id)');
        $this->addSql('CREATE INDEX rlt_buildings_class_idx ON rlt_buildings (class)');
        $this->addSql('CREATE INDEX rlt_buildings_build_type_idx ON rlt_buildings (build_type)');
        $this->addSql('CREATE INDEX rlt_buildings_developers_idx ON rlt_buildings (developer_id)');
        $this->addSql('CREATE INDEX rlt_buildings_facing_idx ON rlt_buildings (facing)');
        $this->addSql('CREATE INDEX rlt_buildings_status_idx ON rlt_buildings (status)');
        $this->addSql('CREATE INDEX rlt_buildings_payment_type_idx ON rlt_buildings (payment_type)');
        $this->addSql('CREATE INDEX rlt_buildings_priceM2_idx ON rlt_buildings (price_per_m2)');
        $this->addSql('CREATE INDEX IDX_18B1B894D2A7E12 ON rlt_buildings_metro (building_id)');
        $this->addSql('CREATE INDEX IDX_18B1B891EA60E4E ON rlt_buildings_metro (metro_id)');
        $this->addSql('ALTER TABLE rlt_buildings ADD CONSTRAINT FK_8238F079C8535AFE FOREIGN KEY (distinct_id) REFERENCES rlt_distincts (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rlt_buildings ADD CONSTRAINT FK_8238F07964DD9267 FOREIGN KEY (developer_id) REFERENCES rlt_developers (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rlt_buildings ADD CONSTRAINT FK_8238F079E40BF469 FOREIGN KEY (user_creator) REFERENCES rlt_users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rlt_buildings ADD CONSTRAINT FK_8238F0796A423DAC FOREIGN KEY (user_updater) REFERENCES rlt_users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE rlt_buildings');
    }
}
