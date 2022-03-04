<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220301110821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE attribute_property_type (attribute_id INT NOT NULL, property_type_id INT NOT NULL, INDEX IDX_364AB376B6E62EFA (attribute_id), INDEX IDX_364AB3769C81C6EB (property_type_id), PRIMARY KEY(attribute_id, property_type_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE attribute_value (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, attribute_id INT DEFAULT NULL, value VARCHAR(255) NOT NULL, INDEX IDX_FE4FBB82549213EC (property_id), INDEX IDX_FE4FBB82B6E62EFA (attribute_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, email VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, message VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, INDEX IDX_BF5476CAA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE unavailability (id INT AUTO_INCREMENT NOT NULL, property_id INT DEFAULT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, INDEX IDX_F0016D1549213EC (property_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE attribute_property_type ADD CONSTRAINT FK_364AB376B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE attribute_property_type ADD CONSTRAINT FK_364AB3769C81C6EB FOREIGN KEY (property_type_id) REFERENCES property_type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE attribute_value ADD CONSTRAINT FK_FE4FBB82549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE attribute_value ADD CONSTRAINT FK_FE4FBB82B6E62EFA FOREIGN KEY (attribute_id) REFERENCES attribute (id)');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE unavailability ADD CONSTRAINT FK_F0016D1549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('ALTER TABLE attribute DROP FOREIGN KEY FK_FA7AEFFB549213EC');
        $this->addSql('DROP INDEX IDX_FA7AEFFB549213EC ON attribute');
        $this->addSql('ALTER TABLE attribute ADD required TINYINT(1) NOT NULL, DROP property_id, DROP value');
        $this->addSql('ALTER TABLE equipment ADD required TINYINT(1) NOT NULL, CHANGE icon value VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FF624B39D');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FCD53EDB6');
        $this->addSql('DROP INDEX UNIQ_B6BD307FCD53EDB6 ON message');
        $this->addSql('DROP INDEX UNIQ_B6BD307FF624B39D ON message');
        $this->addSql('ALTER TABLE message ADD property_id INT DEFAULT NULL, DROP sender_id, DROP receiver_id');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307F549213EC ON message (property_id)');
        $this->addSql('ALTER TABLE property ADD user_id INT DEFAULT NULL, CHANGE literie literie LONGTEXT DEFAULT NULL, CHANGE sanitaire sanitaire LONGTEXT DEFAULT NULL, CHANGE includes includes LONGTEXT DEFAULT NULL, CHANGE activities activities LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_8BF21CDEA76ED395 ON property (user_id)');
        $this->addSql('ALTER TABLE property_type DROP FOREIGN KEY FK_93C6E81354B9D732');
        $this->addSql('DROP INDEX UNIQ_93C6E81354B9D732 ON property_type');
        $this->addSql('ALTER TABLE property_type DROP icon_id');
        $this->addSql('ALTER TABLE reservation ADD user_id INT DEFAULT NULL, ADD first_name VARCHAR(255) NOT NULL, ADD last_name VARCHAR(255) NOT NULL, ADD email VARCHAR(255) NOT NULL, ADD tel VARCHAR(255) NOT NULL, ADD price_ht DOUBLE PRECISION NOT NULL, ADD payment_method VARCHAR(255) NOT NULL, ADD book_number VARCHAR(255) NOT NULL, ADD nbr_personne INT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_42C84955A76ED395 ON reservation (user_id)');
        $this->addSql('ALTER TABLE review ADD user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_794381C6A76ED395 ON review (user_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64986383B10');
        $this->addSql('DROP INDEX UNIQ_8D93D64986383B10 ON user');
        $this->addSql('ALTER TABLE user ADD birth_date DATE DEFAULT NULL, DROP avatar_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE attribute_property_type');
        $this->addSql('DROP TABLE attribute_value');
        $this->addSql('DROP TABLE contact');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE unavailability');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE addresse CHANGE street_name street_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE city city VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE code_zip code_zip VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE country country VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE attribute ADD property_id INT DEFAULT NULL, ADD value VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP required, CHANGE title title VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE attribute ADD CONSTRAINT FK_FA7AEFFB549213EC FOREIGN KEY (property_id) REFERENCES property (id)');
        $this->addSql('CREATE INDEX IDX_FA7AEFFB549213EC ON attribute (property_id)');
        $this->addSql('ALTER TABLE equipment ADD icon VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP value, DROP required, CHANGE title title VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE history CHANGE action action VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE data data LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE image CHANGE path path VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F549213EC');
        $this->addSql('DROP INDEX IDX_B6BD307F549213EC ON message');
        $this->addSql('ALTER TABLE message ADD receiver_id INT DEFAULT NULL, CHANGE message message VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE property_id sender_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FCD53EDB6 FOREIGN KEY (receiver_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B6BD307FCD53EDB6 ON message (receiver_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B6BD307FF624B39D ON message (sender_id)');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDEA76ED395');
        $this->addSql('DROP INDEX IDX_8BF21CDEA76ED395 ON property');
        $this->addSql('ALTER TABLE property DROP user_id, CHANGE title title VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE description description LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE literie literie LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', CHANGE sanitaire sanitaire LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', CHANGE includes includes LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\', CHANGE activities activities LONGTEXT DEFAULT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:array)\'');
        $this->addSql('ALTER TABLE property_type ADD icon_id INT DEFAULT NULL, CHANGE title title VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE property_type ADD CONSTRAINT FK_93C6E81354B9D732 FOREIGN KEY (icon_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_93C6E81354B9D732 ON property_type (icon_id)');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('DROP INDEX IDX_42C84955A76ED395 ON reservation');
        $this->addSql('ALTER TABLE reservation DROP user_id, DROP first_name, DROP last_name, DROP email, DROP tel, DROP price_ht, DROP payment_method, DROP book_number, DROP nbr_personne, CHANGE property property LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\'');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6A76ED395');
        $this->addSql('DROP INDEX UNIQ_794381C6A76ED395 ON review');
        $this->addSql('ALTER TABLE review DROP user_id, CHANGE comment comment VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user ADD avatar_id INT DEFAULT NULL, DROP birth_date, CHANGE email email VARCHAR(180) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE roles roles LONGTEXT NOT NULL COLLATE `utf8mb4_unicode_ci` COMMENT \'(DC2Type:json)\', CHANGE password password VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE first_name first_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE last_name last_name VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE sex sex VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE phone phone VARCHAR(255) NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE api_token api_token VARCHAR(255) DEFAULT NULL COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64986383B10 FOREIGN KEY (avatar_id) REFERENCES image (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64986383B10 ON user (avatar_id)');
    }
}
