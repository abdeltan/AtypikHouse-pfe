<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220106145657 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE addresse (id INT AUTO_INCREMENT NOT NULL, street_number INT NOT NULL, street_name VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, code_zip VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attribute (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_FA7AEFFB549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipment (id INT AUTO_INCREMENT NOT NULL, properties_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, icon VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_D338D5833691D1CA (properties_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE history (id INT AUTO_INCREMENT NOT NULL, action VARCHAR(255) NOT NULL, data LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_C53D045F549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, sender_id INT DEFAULT NULL, receiver_id INT DEFAULT NULL, user_id INT DEFAULT NULL, message VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_B6BD307FF624B39D (sender_id), UNIQUE INDEX UNIQ_B6BD307FCD53EDB6 (receiver_id), INDEX IDX_B6BD307FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property (id INT AUTO_INCREMENT NOT NULL, addresse_id INT DEFAULT NULL, property_type_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, superficie DOUBLE PRECISION NOT NULL, price DOUBLE PRECISION NOT NULL, capacity INT NOT NULL, status TINYINT(1) NOT NULL, rooms INT DEFAULT NULL, pieces INT DEFAULT NULL, water TINYINT(1) DEFAULT NULL, electricity TINYINT(1) DEFAULT NULL, literie LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', sanitaire LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', includes LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', activities LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8BF21CDEB299877A (addresse_id), INDEX IDX_8BF21CDE9C81C6EB (property_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property_type (id INT AUTO_INCREMENT NOT NULL, icon_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_93C6E81354B9D732 (icon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, reserved_property_id INT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, property LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', status TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_42C8495530D4FDC2 (reserved_property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, rating INT NOT NULL, comment VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_794381C6549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, addresse_id INT DEFAULT NULL, avatar_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, sex VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, api_token VARCHAR(255) DEFAULT NULL, status TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649B299877A (addresse_id), UNIQUE INDEX UNIQ_8D93D64986383B10 (avatar_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attribute ADD CONSTRAINT FK_FA7AEFFB549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE equipment ADD CONSTRAINT FK_D338D5833691D1CA FOREIGN KEY (properties_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FCD53EDB6 FOREIGN KEY (receiver_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEB299877A FOREIGN KEY (addresse_id) REFERENCES addresse (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE9C81C6EB FOREIGN KEY (property_type_id) REFERENCES property_type (id)');
        $this->addSql('ALTER TABLE property_type ADD CONSTRAINT FK_93C6E81354B9D732 FOREIGN KEY (icon_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495530D4FDC2 FOREIGN KEY (reserved_property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B299877A FOREIGN KEY (addresse_id) REFERENCES addresse (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64986383B10 FOREIGN KEY (avatar_id) REFERENCES image (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEB299877A');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B299877A');
        $this->addSql('ALTER TABLE property_type DROP FOREIGN KEY FK_93C6E81354B9D732');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64986383B10');
        $this->addSql('ALTER TABLE attribute DROP FOREIGN KEY FK_FA7AEFFB549213EC');
        $this->addSql('ALTER TABLE equipment DROP FOREIGN KEY FK_D338D5833691D1CA');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F549213EC');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495530D4FDC2');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6549213EC');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE9C81C6EB');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FF624B39D');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FCD53EDB6');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA76ED395');
        $this->addSql('DROP TABLE addresse');
        $this->addSql('DROP TABLE attribute');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('DROP TABLE history');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE property');
        $this->addSql('DROP TABLE property_type');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE user');
    }
}
