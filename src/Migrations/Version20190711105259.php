<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190711105259 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, seller INT DEFAULT NULL, category_id INT DEFAULT NULL, name VARCHAR(50) DEFAULT NULL, description VARCHAR(255) DEFAULT NULL, image VARCHAR(255) DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, discount_end_date DATETIME DEFAULT NULL, discount_begin_date DATETIME DEFAULT NULL, created_at DATETIME DEFAULT NULL, discount DOUBLE PRECISION DEFAULT NULL, INDEX IDX_D34A04ADFB1AD3FC (seller), INDEX IDX_D34A04AD12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE flashSales (product_id INT NOT NULL, flash_sale_id INT NOT NULL, INDEX IDX_CC2021084584665A (product_id), INDEX IDX_CC202108BCB1402B (flash_sale_id), PRIMARY KEY(product_id, flash_sale_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, description LONGTEXT DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE delivery (id INT AUTO_INCREMENT NOT NULL, `order` INT DEFAULT NULL, status VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_3781EC10F5299398 (`order`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE flash_sale (id INT AUTO_INCREMENT NOT NULL, begin_date DATETIME DEFAULT NULL, end_date DATETIME DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE products (flash_sale_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_B3BA5A5ABCB1402B (flash_sale_id), INDEX IDX_B3BA5A5A4584665A (product_id), PRIMARY KEY(flash_sale_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, created_at DATETIME NOT NULL, validated_at DATETIME DEFAULT NULL, total_price DOUBLE PRECISION DEFAULT NULL, note VARCHAR(255) DEFAULT NULL, INDEX IDX_F5299398A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_line (id INT AUTO_INCREMENT NOT NULL, `order` INT DEFAULT NULL, product INT DEFAULT NULL, quantity INT DEFAULT NULL, price DOUBLE PRECISION DEFAULT NULL, INDEX IDX_9CE58EE1F5299398 (`order`), INDEX IDX_9CE58EE1D34A04AD (product), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile (id INT AUTO_INCREMENT NOT NULL, user INT DEFAULT NULL, photo VARCHAR(255) DEFAULT NULL, banner VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8157AA0F8D93D649 (user), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, cin VARCHAR(255) DEFAULT NULL, phone_number VARCHAR(255) DEFAULT NULL, email VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json_array)\', address LONGTEXT NOT NULL, status VARCHAR(255) DEFAULT NULL, card_number VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADFB1AD3FC FOREIGN KEY (seller) REFERENCES user (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE flashSales ADD CONSTRAINT FK_CC2021084584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE flashSales ADD CONSTRAINT FK_CC202108BCB1402B FOREIGN KEY (flash_sale_id) REFERENCES flash_sale (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC10F5299398 FOREIGN KEY (`order`) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5ABCB1402B FOREIGN KEY (flash_sale_id) REFERENCES flash_sale (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE1F5299398 FOREIGN KEY (`order`) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE1D34A04AD FOREIGN KEY (product) REFERENCES product (id)');
        $this->addSql('ALTER TABLE profile ADD CONSTRAINT FK_8157AA0F8D93D649 FOREIGN KEY (user) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE flashSales DROP FOREIGN KEY FK_CC2021084584665A');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5A4584665A');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE1D34A04AD');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE flashSales DROP FOREIGN KEY FK_CC202108BCB1402B');
        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5ABCB1402B');
        $this->addSql('ALTER TABLE delivery DROP FOREIGN KEY FK_3781EC10F5299398');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE1F5299398');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADFB1AD3FC');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('ALTER TABLE profile DROP FOREIGN KEY FK_8157AA0F8D93D649');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE flashSales');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE delivery');
        $this->addSql('DROP TABLE flash_sale');
        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_line');
        $this->addSql('DROP TABLE profile');
        $this->addSql('DROP TABLE user');
    }
}
