<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191029115243 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE placed_order_selection (placed_order_id INTEGER NOT NULL, selection_id INTEGER NOT NULL, PRIMARY KEY(placed_order_id, selection_id))');
        $this->addSql('CREATE INDEX IDX_2D0AFA6F47D7D8EA ON placed_order_selection (placed_order_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_2D0AFA6FE48EFE78 ON placed_order_selection (selection_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__selection AS SELECT id, quantity FROM selection');
        $this->addSql('DROP TABLE selection');
        $this->addSql('CREATE TABLE selection (id INTEGER NOT NULL, product_id INTEGER DEFAULT NULL, quantity INTEGER NOT NULL, PRIMARY KEY(id), CONSTRAINT FK_96A50CD74584665A FOREIGN KEY (product_id) REFERENCES product (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO selection (id, quantity) SELECT id, quantity FROM __temp__selection');
        $this->addSql('DROP TABLE __temp__selection');
        $this->addSql('CREATE INDEX IDX_96A50CD74584665A ON selection (product_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE placed_order_selection');
        $this->addSql('DROP INDEX IDX_96A50CD74584665A');
        $this->addSql('CREATE TEMPORARY TABLE __temp__selection AS SELECT id, quantity FROM selection');
        $this->addSql('DROP TABLE selection');
        $this->addSql('CREATE TABLE selection (id INTEGER NOT NULL, quantity INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('INSERT INTO selection (id, quantity) SELECT id, quantity FROM __temp__selection');
        $this->addSql('DROP TABLE __temp__selection');
    }
}
