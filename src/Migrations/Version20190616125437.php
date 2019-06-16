<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190616125437 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE delivery ADD `order` INT DEFAULT NULL');
        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC10F5299398 FOREIGN KEY (`order`) REFERENCES `order` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_3781EC10F5299398 ON delivery (`order`)');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993984584665A');
        $this->addSql('DROP INDEX IDX_F52993984584665A ON `order`');
        $this->addSql('ALTER TABLE `order` CHANGE product_id user INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993988D93D649 FOREIGN KEY (user) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F52993988D93D649 ON `order` (user)');
        $this->addSql('ALTER TABLE order_line ADD `order` INT DEFAULT NULL');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE1F5299398 FOREIGN KEY (`order`) REFERENCES `order` (id)');
        $this->addSql('CREATE INDEX IDX_9CE58EE1F5299398 ON order_line (`order`)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE delivery DROP FOREIGN KEY FK_3781EC10F5299398');
        $this->addSql('DROP INDEX UNIQ_3781EC10F5299398 ON delivery');
        $this->addSql('ALTER TABLE delivery DROP `order`');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993988D93D649');
        $this->addSql('DROP INDEX IDX_F52993988D93D649 ON `order`');
        $this->addSql('ALTER TABLE `order` CHANGE user product_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993984584665A FOREIGN KEY (product_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F52993984584665A ON `order` (product_id)');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE1F5299398');
        $this->addSql('DROP INDEX IDX_9CE58EE1F5299398 ON order_line');
        $this->addSql('ALTER TABLE order_line DROP `order`');
    }
}
