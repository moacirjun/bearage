<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201125054242 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sylius_adjustment (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, order_item_id INT DEFAULT NULL, order_item_unit_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, label VARCHAR(255) DEFAULT NULL, amount INT NOT NULL, is_neutral TINYINT(1) NOT NULL, is_locked TINYINT(1) NOT NULL, origin_code VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_ACA6E0F28D9F6D38 (order_id), INDEX IDX_ACA6E0F2E415FB15 (order_item_id), INDEX IDX_ACA6E0F2F720C233 (order_item_unit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_order (id INT AUTO_INCREMENT NOT NULL, number VARCHAR(255) NOT NULL, external_id VARCHAR(255) DEFAULT NULL, checkout_completed_at DATETIME NOT NULL, notes LONGTEXT DEFAULT NULL, items_total INT NOT NULL, adjustments_total INT NOT NULL, total INT NOT NULL, state VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_order_item (id INT AUTO_INCREMENT NOT NULL, order_id INT DEFAULT NULL, variant_id INT DEFAULT NULL, quantity INT NOT NULL, unit_price INT NOT NULL, total INT NOT NULL, immutable INT NOT NULL, units_total INT NOT NULL, adjustments_total INT NOT NULL, INDEX IDX_77B587ED8D9F6D38 (order_id), INDEX IDX_77B587ED3B69A9AF (variant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_order_item_unit (id INT AUTO_INCREMENT NOT NULL, order_item_id INT DEFAULT NULL, adjustment_total INT NOT NULL, INDEX IDX_82BF226EE415FB15 (order_item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_order_sequence (id INT AUTO_INCREMENT NOT NULL, `index` INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_product (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, enabled TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_product_options (product_id INT NOT NULL, product_option_id INT NOT NULL, INDEX IDX_2B5FF0094584665A (product_id), INDEX IDX_2B5FF009C964ABE2 (product_option_id), PRIMARY KEY(product_id, product_option_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_product_association (id INT AUTO_INCREMENT NOT NULL, association_type_id INT DEFAULT NULL, product_name INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_48E9CDABB1E1C39 (association_type_id), INDEX IDX_48E9CDABD3CB5CA7 (product_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_product_association_product (product_association_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_A427B983BCD0B689 (product_association_id), INDEX IDX_A427B9834584665A (product_id), PRIMARY KEY(product_association_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_product_association_type (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_product_association_type_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_4F618E52C2AC5D3 (translatable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_product_attribute (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, configuration LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', storage_type VARCHAR(255) NOT NULL, position INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_product_attribute_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_93850EBA2C2AC5D3 (translatable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_product_attribute_value (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, attribute_id INT DEFAULT NULL, locale_code VARCHAR(255) NOT NULL, text_value LONGTEXT NOT NULL, boolean_value TINYINT(1) NOT NULL, integer_value INT NOT NULL, float_value DOUBLE PRECISION NOT NULL, datetime_value DATETIME NOT NULL, date_value DATE NOT NULL, json_value LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', INDEX IDX_8A053E544584665A (product_id), INDEX IDX_8A053E54B6E62EFA (attribute_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_product_option (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, position INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_product_option_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_CBA491AD2C2AC5D3 (translatable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_product_option_value (id INT AUTO_INCREMENT NOT NULL, option_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, INDEX IDX_F7FF7D4BA7C41D6F (option_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_product_option_value_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, value VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_8D4382DC2C2AC5D3 (translatable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_product_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, meta_keywords VARCHAR(255) DEFAULT NULL, meta_description VARCHAR(255) DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_105A9082C2AC5D3 (translatable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_product_variant (id INT AUTO_INCREMENT NOT NULL, product_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, position INT NOT NULL, on_hold INT NOT NULL, on_hand INT NOT NULL, cost DOUBLE PRECISION NOT NULL, price DOUBLE PRECISION NOT NULL, sale_price DOUBLE PRECISION DEFAULT NULL, is_tracked TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, INDEX IDX_A29B5234584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sylius_product_variant_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_8DC18EDC2C2AC5D3 (translatable_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tb_user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(25) NOT NULL, password VARCHAR(500) NOT NULL, email VARCHAR(255) NOT NULL, is_enabled TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_D6E3D458F85E0677 (username), UNIQUE INDEX UNIQ_D6E3D458E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sylius_adjustment ADD CONSTRAINT FK_ACA6E0F28D9F6D38 FOREIGN KEY (order_id) REFERENCES sylius_order (id)');
        $this->addSql('ALTER TABLE sylius_adjustment ADD CONSTRAINT FK_ACA6E0F2E415FB15 FOREIGN KEY (order_item_id) REFERENCES sylius_order_item (id)');
        $this->addSql('ALTER TABLE sylius_adjustment ADD CONSTRAINT FK_ACA6E0F2F720C233 FOREIGN KEY (order_item_unit_id) REFERENCES sylius_order_item_unit (id)');
        $this->addSql('ALTER TABLE sylius_order_item ADD CONSTRAINT FK_77B587ED8D9F6D38 FOREIGN KEY (order_id) REFERENCES sylius_order (id)');
        $this->addSql('ALTER TABLE sylius_order_item ADD CONSTRAINT FK_77B587ED3B69A9AF FOREIGN KEY (variant_id) REFERENCES sylius_product_variant (id)');
        $this->addSql('ALTER TABLE sylius_order_item_unit ADD CONSTRAINT FK_82BF226EE415FB15 FOREIGN KEY (order_item_id) REFERENCES sylius_order_item (id)');
        $this->addSql('ALTER TABLE sylius_product_options ADD CONSTRAINT FK_2B5FF0094584665A FOREIGN KEY (product_id) REFERENCES sylius_product (id)');
        $this->addSql('ALTER TABLE sylius_product_options ADD CONSTRAINT FK_2B5FF009C964ABE2 FOREIGN KEY (product_option_id) REFERENCES sylius_product_option (id)');
        $this->addSql('ALTER TABLE sylius_product_association ADD CONSTRAINT FK_48E9CDABB1E1C39 FOREIGN KEY (association_type_id) REFERENCES sylius_product_association_type (id)');
        $this->addSql('ALTER TABLE sylius_product_association ADD CONSTRAINT FK_48E9CDABD3CB5CA7 FOREIGN KEY (product_name) REFERENCES sylius_product (id)');
        $this->addSql('ALTER TABLE sylius_product_association_product ADD CONSTRAINT FK_A427B983BCD0B689 FOREIGN KEY (product_association_id) REFERENCES sylius_product_association (id)');
        $this->addSql('ALTER TABLE sylius_product_association_product ADD CONSTRAINT FK_A427B9834584665A FOREIGN KEY (product_id) REFERENCES sylius_product (id)');
        $this->addSql('ALTER TABLE sylius_product_association_type_translation ADD CONSTRAINT FK_4F618E52C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES sylius_product_association_type (id)');
        $this->addSql('ALTER TABLE sylius_product_attribute_translation ADD CONSTRAINT FK_93850EBA2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES sylius_product_attribute (id)');
        $this->addSql('ALTER TABLE sylius_product_attribute_value ADD CONSTRAINT FK_8A053E544584665A FOREIGN KEY (product_id) REFERENCES sylius_product (id)');
        $this->addSql('ALTER TABLE sylius_product_attribute_value ADD CONSTRAINT FK_8A053E54B6E62EFA FOREIGN KEY (attribute_id) REFERENCES sylius_product_attribute (id)');
        $this->addSql('ALTER TABLE sylius_product_option_translation ADD CONSTRAINT FK_CBA491AD2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES sylius_product_option (id)');
        $this->addSql('ALTER TABLE sylius_product_option_value ADD CONSTRAINT FK_F7FF7D4BA7C41D6F FOREIGN KEY (option_id) REFERENCES sylius_product_option (id)');
        $this->addSql('ALTER TABLE sylius_product_option_value_translation ADD CONSTRAINT FK_8D4382DC2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES sylius_product_option_value (id)');
        $this->addSql('ALTER TABLE sylius_product_translation ADD CONSTRAINT FK_105A9082C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES sylius_product (id)');
        $this->addSql('ALTER TABLE sylius_product_variant ADD CONSTRAINT FK_A29B5234584665A FOREIGN KEY (product_id) REFERENCES sylius_product (id)');
        $this->addSql('ALTER TABLE sylius_product_variant_translation ADD CONSTRAINT FK_8DC18EDC2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES sylius_product_variant (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sylius_adjustment DROP FOREIGN KEY FK_ACA6E0F28D9F6D38');
        $this->addSql('ALTER TABLE sylius_order_item DROP FOREIGN KEY FK_77B587ED8D9F6D38');
        $this->addSql('ALTER TABLE sylius_adjustment DROP FOREIGN KEY FK_ACA6E0F2E415FB15');
        $this->addSql('ALTER TABLE sylius_order_item_unit DROP FOREIGN KEY FK_82BF226EE415FB15');
        $this->addSql('ALTER TABLE sylius_adjustment DROP FOREIGN KEY FK_ACA6E0F2F720C233');
        $this->addSql('ALTER TABLE sylius_product_options DROP FOREIGN KEY FK_2B5FF0094584665A');
        $this->addSql('ALTER TABLE sylius_product_association DROP FOREIGN KEY FK_48E9CDABD3CB5CA7');
        $this->addSql('ALTER TABLE sylius_product_association_product DROP FOREIGN KEY FK_A427B9834584665A');
        $this->addSql('ALTER TABLE sylius_product_attribute_value DROP FOREIGN KEY FK_8A053E544584665A');
        $this->addSql('ALTER TABLE sylius_product_translation DROP FOREIGN KEY FK_105A9082C2AC5D3');
        $this->addSql('ALTER TABLE sylius_product_variant DROP FOREIGN KEY FK_A29B5234584665A');
        $this->addSql('ALTER TABLE sylius_product_association_product DROP FOREIGN KEY FK_A427B983BCD0B689');
        $this->addSql('ALTER TABLE sylius_product_association DROP FOREIGN KEY FK_48E9CDABB1E1C39');
        $this->addSql('ALTER TABLE sylius_product_association_type_translation DROP FOREIGN KEY FK_4F618E52C2AC5D3');
        $this->addSql('ALTER TABLE sylius_product_attribute_translation DROP FOREIGN KEY FK_93850EBA2C2AC5D3');
        $this->addSql('ALTER TABLE sylius_product_attribute_value DROP FOREIGN KEY FK_8A053E54B6E62EFA');
        $this->addSql('ALTER TABLE sylius_product_options DROP FOREIGN KEY FK_2B5FF009C964ABE2');
        $this->addSql('ALTER TABLE sylius_product_option_translation DROP FOREIGN KEY FK_CBA491AD2C2AC5D3');
        $this->addSql('ALTER TABLE sylius_product_option_value DROP FOREIGN KEY FK_F7FF7D4BA7C41D6F');
        $this->addSql('ALTER TABLE sylius_product_option_value_translation DROP FOREIGN KEY FK_8D4382DC2C2AC5D3');
        $this->addSql('ALTER TABLE sylius_order_item DROP FOREIGN KEY FK_77B587ED3B69A9AF');
        $this->addSql('ALTER TABLE sylius_product_variant_translation DROP FOREIGN KEY FK_8DC18EDC2C2AC5D3');
        $this->addSql('DROP TABLE sylius_adjustment');
        $this->addSql('DROP TABLE sylius_order');
        $this->addSql('DROP TABLE sylius_order_item');
        $this->addSql('DROP TABLE sylius_order_item_unit');
        $this->addSql('DROP TABLE sylius_order_sequence');
        $this->addSql('DROP TABLE sylius_product');
        $this->addSql('DROP TABLE sylius_product_options');
        $this->addSql('DROP TABLE sylius_product_association');
        $this->addSql('DROP TABLE sylius_product_association_product');
        $this->addSql('DROP TABLE sylius_product_association_type');
        $this->addSql('DROP TABLE sylius_product_association_type_translation');
        $this->addSql('DROP TABLE sylius_product_attribute');
        $this->addSql('DROP TABLE sylius_product_attribute_translation');
        $this->addSql('DROP TABLE sylius_product_attribute_value');
        $this->addSql('DROP TABLE sylius_product_option');
        $this->addSql('DROP TABLE sylius_product_option_translation');
        $this->addSql('DROP TABLE sylius_product_option_value');
        $this->addSql('DROP TABLE sylius_product_option_value_translation');
        $this->addSql('DROP TABLE sylius_product_translation');
        $this->addSql('DROP TABLE sylius_product_variant');
        $this->addSql('DROP TABLE sylius_product_variant_translation');
        $this->addSql('DROP TABLE tb_user');
    }
}
