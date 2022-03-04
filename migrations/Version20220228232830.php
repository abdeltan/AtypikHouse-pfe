<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220228232830 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE addresse (id INT AUTO_INCREMENT NOT NULL, street_number INT NOT NULL, street_name VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, code_zip VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attribute (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, required TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attribute_property_type (attribute_id INT NOT NULL, property_type_id INT NOT NULL, INDEX IDX_364AB376B6E62EFA (attribute_id), INDEX IDX_364AB3769C81C6EB (property_type_id), PRIMARY KEY(attribute_id, property_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attribute_value (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, attribute_id INT DEFAULT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_FE4FBB82549213EC (property_id), INDEX IDX_FE4FBB82B6E62EFA (attribute_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, email VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipment (id INT AUTO_INCREMENT NOT NULL, properties_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, value VARCHAR(255) NOT NULL, required TINYINT(1) NOT NULL, INDEX IDX_D338D5833691D1CA (properties_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE history (id INT AUTO_INCREMENT NOT NULL, action VARCHAR(255) NOT NULL, data LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_C53D045F549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, property_id INT DEFAULT NULL, message VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_B6BD307FA76ED395 (user_id), INDEX IDX_B6BD307F549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, message VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, INDEX IDX_BF5476CAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property (id INT AUTO_INCREMENT NOT NULL, addresse_id INT DEFAULT NULL, property_type_id INT NOT NULL, user_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, superficie DOUBLE PRECISION NOT NULL, price DOUBLE PRECISION NOT NULL, capacity INT NOT NULL, status TINYINT(1) NOT NULL, rooms INT DEFAULT NULL, pieces INT DEFAULT NULL, water TINYINT(1) DEFAULT NULL, electricity TINYINT(1) DEFAULT NULL, literie LONGTEXT DEFAULT NULL, sanitaire LONGTEXT DEFAULT NULL, includes LONGTEXT DEFAULT NULL, activities LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_8BF21CDEB299877A (addresse_id), INDEX IDX_8BF21CDE9C81C6EB (property_type_id), INDEX IDX_8BF21CDEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE property_type (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservation (id INT AUTO_INCREMENT NOT NULL, reserved_property_id INT NOT NULL, user_id INT DEFAULT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, property LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', status TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, tel VARCHAR(255) NOT NULL, price_ht DOUBLE PRECISION NOT NULL, payment_method VARCHAR(255) NOT NULL, book_number VARCHAR(255) NOT NULL, nbr_personne INT NOT NULL, INDEX IDX_42C8495530D4FDC2 (reserved_property_id), INDEX IDX_42C84955A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, user_id INT DEFAULT NULL, rating INT NOT NULL, comment VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_794381C6549213EC (property_id), UNIQUE INDEX UNIQ_794381C6A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unavailability (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, INDEX IDX_F0016D1549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, addresse_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, sex VARCHAR(255) NOT NULL, phone VARCHAR(255) NOT NULL, api_token VARCHAR(255) DEFAULT NULL, status TINYINT(1) NOT NULL, is_verified TINYINT(1) NOT NULL, birth_date DATE DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D649B299877A (addresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attribute_property_type ADD CONSTRAINT FK_364AB376B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE attribute_property_type ADD CONSTRAINT FK_364AB3769C81C6EB FOREIGN KEY (property_type_id) REFERENCES property_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE attribute_value ADD CONSTRAINT FK_FE4FBB82549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE attribute_value ADD CONSTRAINT FK_FE4FBB82B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id)');
        $this->addSql('ALTER TABLE equipment ADD CONSTRAINT FK_D338D5833691D1CA FOREIGN KEY (properties_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEB299877A FOREIGN KEY (addresse_id) REFERENCES addresse (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDE9C81C6EB FOREIGN KEY (property_type_id) REFERENCES property_type (id)');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C8495530D4FDC2 FOREIGN KEY (reserved_property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE unavailability ADD CONSTRAINT FK_F0016D1549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649B299877A FOREIGN KEY (addresse_id) REFERENCES addresse (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEB299877A');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649B299877A');
        $this->addSql('ALTER TABLE attribute_property_type DROP FOREIGN KEY FK_364AB376B6E62EFA');
        $this->addSql('ALTER TABLE attribute_value DROP FOREIGN KEY FK_FE4FBB82B6E62EFA');
        $this->addSql('ALTER TABLE attribute_value DROP FOREIGN KEY FK_FE4FBB82549213EC');
        $this->addSql('ALTER TABLE equipment DROP FOREIGN KEY FK_D338D5833691D1CA');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F549213EC');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F549213EC');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495530D4FDC2');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6549213EC');
        $this->addSql('ALTER TABLE unavailability DROP FOREIGN KEY FK_F0016D1549213EC');
        $this->addSql('ALTER TABLE attribute_property_type DROP FOREIGN KEY FK_364AB3769C81C6EB');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDE9C81C6EB');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FA76ED395');
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAA76ED395');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEA76ED395');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6A76ED395');
        $this->addSql('DROP TABLE addresse');
        $this->addSql('DROP TABLE attribute');
        $this->addSql('DROP TABLE attribute_property_type');
        $this->addSql('DROP TABLE attribute_value');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE equipment');
        $this->addSql('DROP TABLE history');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE property');
        $this->addSql('DROP TABLE property_type');
        $this->addSql('DROP TABLE reservation');
        $this->addSql('DROP TABLE review');
        $this->addSql('DROP TABLE unavailability');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
