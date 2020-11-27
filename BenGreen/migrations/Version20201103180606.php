<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201103180606 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customers RENAME INDEX idx_62534e219749932e TO IDX_62534E218C03F15C');
        $this->addSql('ALTER TABLE customers RENAME INDEX idx_62534e215e418e53 TO IDX_62534E2132397613');
        $this->addSql('ALTER TABLE delivery CHANGE delivery_date delivery_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE delivery RENAME INDEX idx_3781ec1047bb9876 TO IDX_3781EC1017E8A46A');
        $this->addSql('ALTER TABLE delivery RENAME INDEX idx_3781ec104ca4fd72 TO IDX_3781EC10C3568B40');
        $this->addSql('ALTER TABLE orderdetail RENAME INDEX idx_27a0e7f26bf977ff TO IDX_27A0E7F2DCB2D37');
        $this->addSql('ALTER TABLE orderdetail RENAME INDEX idx_27a0e7f29f1d6087 TO IDX_27A0E7F26C8A81A9');
        $this->addSql('ALTER TABLE products RENAME INDEX idx_b3ba5a5aacec0fef TO IDX_B3BA5A5A3BD38833');
        $this->addSql('ALTER TABLE purchases RENAME INDEX idx_aa6431fe2603f3f7 TO IDX_AA6431FE355AF43');
        $this->addSql('ALTER TABLE purchases RENAME INDEX idx_aa6431fe9f1d6087 TO IDX_AA6431FE6C8A81A9');
        $this->addSql('ALTER TABLE rubrique DROP FOREIGN KEY FK_8FA4097CC3E28062');
        $this->addSql('DROP INDEX IDX_8FA4097CC3E28062 ON rubrique');
        $this->addSql('ALTER TABLE rubrique ADD rubrique_picture VARCHAR(50) DEFAULT NULL, CHANGE rubrique_sous parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rubrique ADD CONSTRAINT FK_8FA4097C727ACA70 FOREIGN KEY (parent_id) REFERENCES rubrique (id)');
        $this->addSql('CREATE INDEX IDX_8FA4097C727ACA70 ON rubrique (parent_id)');
        $this->addSql('ALTER TABLE suppliers DROP FOREIGN KEY FK_AC28B95C9C3FC959');
        $this->addSql('DROP INDEX IDX_AC28B95C9C3FC959 ON suppliers');
        $this->addSql('ALTER TABLE suppliers CHANGE supplierstype_id_id supplierstype_id INT NOT NULL');
        $this->addSql('ALTER TABLE suppliers ADD CONSTRAINT FK_AC28B95CEAF08F95 FOREIGN KEY (supplierstype_id) REFERENCES supplierstype (id)');
        $this->addSql('CREATE INDEX IDX_AC28B95CEAF08F95 ON suppliers (supplierstype_id)');
        $this->addSql('ALTER TABLE totalorder RENAME INDEX idx_d614707e4ca4fd72 TO IDX_D614707EC3568B40');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE customers RENAME INDEX idx_62534e2132397613 TO IDX_62534E215E418E53');
        $this->addSql('ALTER TABLE customers RENAME INDEX idx_62534e218c03f15c TO IDX_62534E219749932E');
        $this->addSql('ALTER TABLE delivery CHANGE delivery_date delivery_date DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE delivery RENAME INDEX idx_3781ec10c3568b40 TO IDX_3781EC104CA4FD72');
        $this->addSql('ALTER TABLE delivery RENAME INDEX idx_3781ec1017e8a46a TO IDX_3781EC1047BB9876');
        $this->addSql('ALTER TABLE orderdetail RENAME INDEX idx_27a0e7f26c8a81a9 TO IDX_27A0E7F29F1D6087');
        $this->addSql('ALTER TABLE orderdetail RENAME INDEX idx_27a0e7f2dcb2d37 TO IDX_27A0E7F26BF977FF');
        $this->addSql('ALTER TABLE products RENAME INDEX idx_b3ba5a5a3bd38833 TO IDX_B3BA5A5AACEC0FEF');
        $this->addSql('ALTER TABLE purchases RENAME INDEX idx_aa6431fe6c8a81a9 TO IDX_AA6431FE9F1D6087');
        $this->addSql('ALTER TABLE purchases RENAME INDEX idx_aa6431fe355af43 TO IDX_AA6431FE2603F3F7');
        $this->addSql('ALTER TABLE rubrique DROP FOREIGN KEY FK_8FA4097C727ACA70');
        $this->addSql('DROP INDEX IDX_8FA4097C727ACA70 ON rubrique');
        $this->addSql('ALTER TABLE rubrique DROP rubrique_picture, CHANGE parent_id rubrique_sous INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rubrique ADD CONSTRAINT FK_8FA4097CC3E28062 FOREIGN KEY (rubrique_sous) REFERENCES rubrique (id)');
        $this->addSql('CREATE INDEX IDX_8FA4097CC3E28062 ON rubrique (rubrique_sous)');
        $this->addSql('ALTER TABLE suppliers DROP FOREIGN KEY FK_AC28B95CEAF08F95');
        $this->addSql('DROP INDEX IDX_AC28B95CEAF08F95 ON suppliers');
        $this->addSql('ALTER TABLE suppliers CHANGE supplierstype_id supplierstype_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE suppliers ADD CONSTRAINT FK_AC28B95C9C3FC959 FOREIGN KEY (supplierstype_id_id) REFERENCES supplierstype (id)');
        $this->addSql('CREATE INDEX IDX_AC28B95C9C3FC959 ON suppliers (supplierstype_id_id)');
        $this->addSql('ALTER TABLE totalorder RENAME INDEX idx_d614707ec3568b40 TO IDX_D614707E4CA4FD72');
    }
}
