<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181103221910 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE rlt_users (id SERIAL NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled BOOLEAN NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, roles TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT \'now()\' DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_884656E792FC23A8 ON rlt_users (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_884656E7A0D96FBF ON rlt_users (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_884656E7C05FB297 ON rlt_users (confirmation_token)');
        $this->addSql('CREATE TABLE rlt_user_groups (id SERIAL NOT NULL, name VARCHAR(180) NOT NULL, roles TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_153B36105E237E06 ON rlt_user_groups (name)');
        $this->addSql('CREATE TABLE rlt_users_user_groups (user_id INT NOT NULL, group_id INT NOT NULL, PRIMARY KEY(user_id, group_id))');
        $this->addSql('CREATE INDEX IDX_29ADB803A76ED395 ON rlt_users_user_groups (user_id)');
        $this->addSql('CREATE INDEX IDX_29ADB803FE54D947 ON rlt_users_user_groups (group_id)');
        $this->addSql('ALTER TABLE rlt_users_user_groups ADD CONSTRAINT FK_29ADB803A76ED395 FOREIGN KEY (user_id) REFERENCES rlt_users (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE rlt_users_user_groups ADD CONSTRAINT FK_29ADB803FE54D947 FOREIGN KEY (group_id) REFERENCES rlt_user_groups (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE rlt_users_user_groups DROP CONSTRAINT FK_29ADB803A76ED395');
        $this->addSql('DROP TABLE rlt_users_user_groups');
        $this->addSql('DROP TABLE rlt_users');
        $this->addSql('DROP TABLE rlt_user_groups');
    }
}
