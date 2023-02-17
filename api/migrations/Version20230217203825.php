<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230217203825 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `products` (id INT AUTO_INCREMENT NOT NULL, product_stork_id INT DEFAULT NULL, delivery_number VARCHAR(255) NOT NULL, quantity INT NOT NULL, price INT NOT NULL, date DATE NOT NULL, INDEX IDX_B3BA5A5A9BFDB5B5 (product_stork_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `products_stock` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, quantity INT DEFAULT 0 NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `products` ADD CONSTRAINT FK_B3BA5A5A9BFDB5B5 FOREIGN KEY (product_stork_id) REFERENCES `products_stock` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `products` DROP FOREIGN KEY FK_B3BA5A5A9BFDB5B5');
        $this->addSql('DROP TABLE `products`');
        $this->addSql('DROP TABLE `products_stock`');
    }
}
