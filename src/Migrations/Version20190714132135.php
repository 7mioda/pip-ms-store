<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190714132135 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `like` (id INT AUTO_INCREMENT NOT NULL, user INT DEFAULT NULL, post INT DEFAULT NULL, INDEX IDX_AC6340B38D93D649 (user), INDEX IDX_AC6340B35A8A6C8D (post), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B38D93D649 FOREIGN KEY (user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `like` ADD CONSTRAINT FK_AC6340B35A8A6C8D FOREIGN KEY (post) REFERENCES post (id)');
        $this->addSql('ALTER TABLE comment CHANGE content content LONGTEXT NOT NULL, CHANGE user user INT DEFAULT NULL, CHANGE post post INT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C8D93D649 FOREIGN KEY (user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C5A8A6C8D FOREIGN KEY (post) REFERENCES post (id)');
        $this->addSql('CREATE INDEX IDX_9474526C8D93D649 ON comment (user)');
        $this->addSql('CREATE INDEX IDX_9474526C5A8A6C8D ON comment (post)');
        $this->addSql('ALTER TABLE post ADD user INT DEFAULT NULL, ADD image VARCHAR(255) NOT NULL, DROP id_user, DROP likes, DROP comments, CHANGE created_at created_at DATETIME DEFAULT NULL, CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D8D93D649 FOREIGN KEY (user) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D8D93D649 ON post (user)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE `like`');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C8D93D649');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526C5A8A6C8D');
        $this->addSql('DROP INDEX IDX_9474526C8D93D649 ON comment');
        $this->addSql('DROP INDEX IDX_9474526C5A8A6C8D ON comment');
        $this->addSql('ALTER TABLE comment CHANGE user user INT NOT NULL, CHANGE post post INT NOT NULL, CHANGE content content VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE created_at created_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D8D93D649');
        $this->addSql('DROP INDEX IDX_5A8A6C8D8D93D649 ON post');
        $this->addSql('ALTER TABLE post ADD id_user INT NOT NULL, ADD comments INT DEFAULT NULL, DROP image, CHANGE created_at created_at DATE NOT NULL, CHANGE updated_at updated_at DATE DEFAULT NULL, CHANGE user likes INT DEFAULT NULL');
    }
}
