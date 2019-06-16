<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190616120714 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE products (flash_sale_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_B3BA5A5ABCB1402B (flash_sale_id), INDEX IDX_B3BA5A5A4584665A (product_id), PRIMARY KEY(flash_sale_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE flashSales (product_id INT NOT NULL, flash_sale_id INT NOT NULL, INDEX IDX_CC2021084584665A (product_id), INDEX IDX_CC202108BCB1402B (flash_sale_id), PRIMARY KEY(product_id, flash_sale_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5ABCB1402B FOREIGN KEY (flash_sale_id) REFERENCES flash_sale (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A4584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE flashSales ADD CONSTRAINT FK_CC2021084584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE flashSales ADD CONSTRAINT FK_CC202108BCB1402B FOREIGN KEY (flash_sale_id) REFERENCES flash_sale (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE products');
        $this->addSql('DROP TABLE flashSales');
    }
}
