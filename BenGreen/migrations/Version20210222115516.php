<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210222115516 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orderdetail DROP INDEX IDX_27A0E7F26C8A81A9, ADD UNIQUE INDEX UNIQ_27A0E7F26C8A81A9 (products_id)');
        $this->addSql('ALTER TABLE orderdetail CHANGE orderdetail_price orderdetail_price NUMERIC(8, 2) NOT NULL');
        $this->addSql('ALTER TABLE totalorder CHANGE customers_id customers_id INT NOT NULL, CHANGE status status VARCHAR(255) NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orderdetail DROP INDEX UNIQ_27A0E7F26C8A81A9, ADD INDEX IDX_27A0E7F26C8A81A9 (products_id)');
        $this->addSql('ALTER TABLE orderdetail CHANGE orderdetail_price orderdetail_price NUMERIC(8, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE totalorder CHANGE customers_id customers_id INT DEFAULT NULL, CHANGE updated_at updated_at DATE DEFAULT NULL, CHANGE status status VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'cart\' NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
