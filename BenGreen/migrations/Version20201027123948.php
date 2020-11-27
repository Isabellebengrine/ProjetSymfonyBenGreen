<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201027123948 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        /*$this->addSql('ALTER TABLE customers DROP FOREIGN KEY FK_62534E215E418E53');
        $this->addSql('ALTER TABLE customers DROP FOREIGN KEY FK_62534E219749932E');
        $this->addSql('DROP INDEX IDX_62534E215E418E53 ON customers');
        $this->addSql('DROP INDEX IDX_62534E219749932E ON customers');
        $this->addSql('ALTER TABLE customers CHANGE employee_id employee_id_id INT DEFAULT NULL, CHANGE categorietva_id categorietva_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE customers ADD CONSTRAINT FK_62534E215E418E53 FOREIGN KEY (categorietva_id_id) REFERENCES categorietva (id)');
        $this->addSql('ALTER TABLE customers ADD CONSTRAINT FK_62534E219749932E FOREIGN KEY (employee_id_id) REFERENCES employee (id)');
        $this->addSql('CREATE INDEX IDX_62534E215E418E53 ON customers (categorietva_id_id)');
        $this->addSql('CREATE INDEX IDX_62534E219749932E ON customers (employee_id_id)');
    */  $this->addSql('ALTER TABLE totalorder ADD customers_id INT NOT NULL');
        $this->addSql('ALTER TABLE totalorder ADD CONSTRAINT FK_D614707E4CA4FD72 FOREIGN KEY (customers_id) REFERENCES customers (id)');
        $this->addSql('CREATE INDEX IDX_D614707E4CA4FD72 ON totalorder (customers_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
    /*  $this->addSql('ALTER TABLE customers DROP FOREIGN KEY FK_62534E219749932E');
        $this->addSql('ALTER TABLE customers DROP FOREIGN KEY FK_62534E215E418E53');
        $this->addSql('DROP INDEX IDX_62534E219749932E ON customers');
        $this->addSql('DROP INDEX IDX_62534E215E418E53 ON customers');
        $this->addSql('ALTER TABLE customers CHANGE employee_id_id employee_id INT DEFAULT NULL, CHANGE categorietva_id_id categorietva_id INT NOT NULL');
        $this->addSql('ALTER TABLE customers ADD CONSTRAINT FK_62534E219749932E FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE customers ADD CONSTRAINT FK_62534E215E418E53 FOREIGN KEY (categorietva_id) REFERENCES categorietva (id)');
        $this->addSql('CREATE INDEX IDX_62534E219749932E ON customers (employee_id)');
        $this->addSql('CREATE INDEX IDX_62534E215E418E53 ON customers (categorietva_id)');
 */     $this->addSql('ALTER TABLE totalorder DROP FOREIGN KEY FK_D614707E4CA4FD72');
        $this->addSql('DROP INDEX IDX_D614707E4CA4FD72 ON totalorder');
        $this->addSql('ALTER TABLE totalorder DROP customers_id');
    }
}
