<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181104164001 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE rlt_users ALTER updated_at DROP DEFAULT');
        $this->addSql('ALTER TABLE rlt_users ALTER updated_at DROP NOT NULL');
        $this->addSql('ALTER TABLE rlt_news ALTER updated_at DROP DEFAULT');
        $this->addSql('ALTER TABLE rlt_news ALTER updated_at DROP NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE rlt_users ALTER updated_at SET DEFAULT \'2018-11-03 22:30:35.552881\'');
        $this->addSql('ALTER TABLE rlt_users ALTER updated_at SET NOT NULL');
        $this->addSql('ALTER TABLE rlt_news ALTER updated_at SET DEFAULT \'2018-11-03 22:39:15.303745\'');
        $this->addSql('ALTER TABLE rlt_news ALTER updated_at SET NOT NULL');
    }
}
