<?php

declare(strict_types=1);

namespace Sylius\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200916093101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Make a price on channel pricing nullable';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf(!is_a($this->connection->getDatabasePlatform(), \Doctrine\DBAL\Platforms\MySqlPlatform::class, true), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_channel_pricing CHANGE price price INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf(!is_a($this->connection->getDatabasePlatform(), \Doctrine\DBAL\Platforms\MySqlPlatform::class, true), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE sylius_channel_pricing CHANGE price price INT NOT NULL');
    }
}
