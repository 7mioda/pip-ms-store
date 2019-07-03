<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190703013202 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE delivery DROP parcour, DROP time_valid_user');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993988D93D649');
        $this->addSql('DROP INDEX IDX_F52993988D93D649 ON `order`');
        $this->addSql('ALTER TABLE `order` ADD user_id INT NOT NULL, ADD validated_at DATETIME DEFAULT NULL, DROP user, CHANGE creation_date created_at DATETIME NOT NULL, CHANGE price total_price DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON `order` (user_id)');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE1D34A04AD');
        $this->addSql('ALTER TABLE order_line DROP description');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE1D34A04AD FOREIGN KEY (product) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD64C19C1');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADFB1AD3FC');
        $this->addSql('ALTER TABLE product CHANGE image image VARCHAR(255) DEFAULT NULL, CHANGE discount discount DOUBLE PRECISION DEFAULT NULL, CHANGE statut status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD64C19C1 FOREIGN KEY (category) REFERENCES category (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADFB1AD3FC FOREIGN KEY (seller) REFERENCES user (id)');
        $this->addSql('ALTER TABLE profile DROP session_expiration, CHANGE photo photo VARCHAR(255) DEFAULT NULL, CHANGE banner banner VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE delivery ADD parcour VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD time_valid_user DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('DROP INDEX IDX_F5299398A76ED395 ON `order`');
        $this->addSql('ALTER TABLE `order` ADD user INT DEFAULT NULL, DROP user_id, DROP validated_at, CHANGE created_at creation_date DATETIME NOT NULL, CHANGE total_price price DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993988D93D649 FOREIGN KEY (user) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F52993988D93D649 ON `order` (user)');
        $this->addSql('ALTER TABLE order_line DROP FOREIGN KEY FK_9CE58EE1D34A04AD');
        $this->addSql('ALTER TABLE order_line ADD description VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE order_line ADD CONSTRAINT FK_9CE58EE1D34A04AD FOREIGN KEY (product) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04ADFB1AD3FC');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD64C19C1');
        $this->addSql('ALTER TABLE product CHANGE image image LONGBLOB DEFAULT NULL, CHANGE discount discount INT DEFAULT NULL, CHANGE status statut VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04ADFB1AD3FC FOREIGN KEY (seller) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD64C19C1 FOREIGN KEY (category) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE profile ADD session_expiration TIME DEFAULT NULL, CHANGE photo photo LONGBLOB DEFAULT NULL, CHANGE banner banner TINYINT(1) DEFAULT NULL');
    }
}
