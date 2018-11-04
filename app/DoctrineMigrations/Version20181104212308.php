<?php declare(strict_types=1);

namespace Application\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181104212308 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE rlt_buildings ALTER description TYPE TEXT');
        $this->addSql('ALTER TABLE rlt_developers ALTER description TYPE TEXT');
        $this->addSql('ALTER TABLE rlt_banks ALTER description TYPE TEXT');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE rlt_banks ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE rlt_developers ALTER description TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE rlt_buildings ALTER description TYPE VARCHAR(255)');
    }
}
