<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201027142939 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE products ADD rubrique_id INT NOT NULL');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5AACEC0FEF FOREIGN KEY (rubrique_id) REFERENCES rubrique (id)');
        $this->addSql('CREATE INDEX IDX_B3BA5A5AACEC0FEF ON products (rubrique_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs

        $this->addSql('ALTER TABLE products DROP FOREIGN KEY FK_B3BA5A5AACEC0FEF');
        $this->addSql('DROP INDEX IDX_B3BA5A5AACEC0FEF ON products');
        $this->addSql('ALTER TABLE products DROP rubrique_id');
    }
}
