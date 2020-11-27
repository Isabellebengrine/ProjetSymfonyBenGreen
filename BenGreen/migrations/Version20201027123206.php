<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201027123206 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customers ADD employee_id INT DEFAULT NULL, ADD categorietva_id INT NOT NULL');
        $this->addSql('ALTER TABLE customers ADD CONSTRAINT FK_62534E219749932E FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE customers ADD CONSTRAINT FK_62534E215E418E53 FOREIGN KEY (categorietva_id) REFERENCES categorietva (id)');
        $this->addSql('CREATE INDEX IDX_62534E219749932E ON customers (employee_id)');
        $this->addSql('CREATE INDEX IDX_62534E215E418E53 ON customers (categorietva_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customers DROP FOREIGN KEY FK_62534E219749932E');
        $this->addSql('ALTER TABLE customers DROP FOREIGN KEY FK_62534E215E418E53');
        $this->addSql('DROP INDEX IDX_62534E219749932E ON customers');
        $this->addSql('DROP INDEX IDX_62534E215E418E53 ON customers');
        $this->addSql('ALTER TABLE customers DROP employee_id, DROP categorietva_id');
    }
}
