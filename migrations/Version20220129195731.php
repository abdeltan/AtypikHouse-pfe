<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220129195731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955F5B7AF75');
        $this->addSql('DROP INDEX UNIQ_42C84955F5B7AF75 ON reservation');
        $this->addSql('ALTER TABLE reservation DROP address_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reservation ADD address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955F5B7AF75 FOREIGN KEY (address_id) REFERENCES addresse (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_42C84955F5B7AF75 ON reservation (address_id)');
    }
}
