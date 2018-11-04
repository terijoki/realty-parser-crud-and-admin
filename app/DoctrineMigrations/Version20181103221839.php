<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181103221839 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE rlt_news (id SERIAL NOT NULL, developer_id INT DEFAULT NULL, bank_id INT DEFAULT NULL, building_id INT DEFAULT NULL, user_creator INT DEFAULT NULL, user_updater INT DEFAULT NULL, name VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, external_id SMALLINT NOT NULL, date VARCHAR(255) NOT NULL, images JSONB DEFAULT \'[]\' NOT NULL, text VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D1263E945E237E06 ON rlt_news (name)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D1263E942B36786B ON rlt_news (title)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D1263E949F75D7B0 ON rlt_news (external_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D1263E94AA9E377A ON rlt_news (date)');
        $this->addSql('CREATE INDEX IDX_D1263E94E40BF469 ON rlt_news (user_creator)');
        $this->addSql('CREATE INDEX IDX_D1263E946A423DAC ON rlt_news (user_updater)');
        $this->addSql('CREATE INDEX rlt_news_name_idx ON rlt_news (name)');
        $this->addSql('CREATE INDEX rlt_news_date_idx ON rlt_news (date)');
        $this->addSql('CREATE INDEX rlt_news_text_idx ON rlt_news (text)');
        $this->addSql('CREATE INDEX rlt_news_developers_idx ON rlt_news (developer_id)');
        $this->addSql('CREATE INDEX rlt_news_buildings_idx ON rlt_news (building_id)');
        $this->addSql('CREATE INDEX rlt_news_banks_idx ON rlt_news (bank_id)');
        $this->addSql('ALTER TABLE rlt_news ADD CONSTRAINT FK_D1263E9464DD9267 FOREIGN KEY (developer_id) REFERENCES rlt_developers (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rlt_news ADD CONSTRAINT FK_D1263E9411C8FB41 FOREIGN KEY (bank_id) REFERENCES rlt_banks (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rlt_news ADD CONSTRAINT FK_D1263E944D2A7E12 FOREIGN KEY (building_id) REFERENCES rlt_buildings (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rlt_news ADD CONSTRAINT FK_D1263E94E40BF469 FOREIGN KEY (user_creator) REFERENCES rlt_users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rlt_news ADD CONSTRAINT FK_D1263E946A423DAC FOREIGN KEY (user_updater) REFERENCES rlt_users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP TABLE rlt_news');
    }
}
