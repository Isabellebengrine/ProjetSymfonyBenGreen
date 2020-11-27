<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201027113851 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE suppliers ADD supplierstype_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE suppliers ADD CONSTRAINT FK_AC28B95C9C3FC959 FOREIGN KEY (supplierstype_id_id) REFERENCES supplierstype (id)');
        $this->addSql('CREATE INDEX IDX_AC28B95C9C3FC959 ON suppliers (supplierstype_id_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE suppliers DROP FOREIGN KEY FK_AC28B95C9C3FC959');
        $this->addSql('DROP INDEX IDX_AC28B95C9C3FC959 ON suppliers');
        $this->addSql('ALTER TABLE suppliers DROP supplierstype_id_id');
    }
}
