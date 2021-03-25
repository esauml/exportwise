<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210324111057 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE acceptance_order (id INT AUTO_INCREMENT NOT NULL, seller_id INT NOT NULL, buyer_id INT NOT NULL, purchase_order_id INT NOT NULL, subtotal DOUBLE PRECISION DEFAULT NULL, expected_arrive_date DATE DEFAULT NULL, date_done DATETIME NOT NULL, status SMALLINT NOT NULL, INDEX IDX_42BD34268DE820D9 (seller_id), INDEX IDX_42BD34266C755722 (buyer_id), INDEX IDX_42BD3426A45D7E6A (purchase_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detail_acceptance_order (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, acceptance_order_id INT NOT NULL, quantity DOUBLE PRECISION NOT NULL, unit VARCHAR(10) NOT NULL, INDEX IDX_60B2650A4584665A (product_id), INDEX IDX_60B2650A547BC3E6 (acceptance_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE detail_purchase_order (id INT AUTO_INCREMENT NOT NULL, product_id INT NOT NULL, purchase_order_id INT NOT NULL, quantity DOUBLE PRECISION NOT NULL, unit VARCHAR(10) NOT NULL, INDEX IDX_B1D98384584665A (product_id), INDEX IDX_B1D9838A45D7E6A (purchase_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enterprise (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, company_name VARCHAR(30) NOT NULL, logo LONGTEXT DEFAULT NULL, country VARCHAR(30) NOT NULL, phone VARCHAR(30) DEFAULT NULL, contact_name VARCHAR(50) DEFAULT NULL, UNIQUE INDEX UNIQ_B1B36A03E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id INT AUTO_INCREMENT NOT NULL, seller_id INT NOT NULL, name VARCHAR(30) NOT NULL, description VARCHAR(40) NOT NULL, price DOUBLE PRECISION NOT NULL, image LONGTEXT DEFAULT NULL, status SMALLINT NOT NULL, INDEX IDX_D34A04AD8DE820D9 (seller_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase_order (id INT AUTO_INCREMENT NOT NULL, buyer_id INT NOT NULL, seller_id INT NOT NULL, date_done DATETIME NOT NULL, status SMALLINT NOT NULL, INDEX IDX_21E210B26C755722 (buyer_id), INDEX IDX_21E210B28DE820D9 (seller_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shipment (id INT AUTO_INCREMENT NOT NULL, acceptance_order_id INT NOT NULL, posting_date DATETIME NOT NULL, arrive_date DATETIME DEFAULT NULL, comision DOUBLE PRECISION NOT NULL, total DOUBLE PRECISION NOT NULL, status SMALLINT NOT NULL, INDEX IDX_2CB20DC547BC3E6 (acceptance_order_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE acceptance_order ADD CONSTRAINT FK_42BD34268DE820D9 FOREIGN KEY (seller_id) REFERENCES enterprise (id)');
        $this->addSql('ALTER TABLE acceptance_order ADD CONSTRAINT FK_42BD34266C755722 FOREIGN KEY (buyer_id) REFERENCES enterprise (id)');
        $this->addSql('ALTER TABLE acceptance_order ADD CONSTRAINT FK_42BD3426A45D7E6A FOREIGN KEY (purchase_order_id) REFERENCES purchase_order (id)');
        $this->addSql('ALTER TABLE detail_acceptance_order ADD CONSTRAINT FK_60B2650A4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE detail_acceptance_order ADD CONSTRAINT FK_60B2650A547BC3E6 FOREIGN KEY (acceptance_order_id) REFERENCES acceptance_order (id)');
        $this->addSql('ALTER TABLE detail_purchase_order ADD CONSTRAINT FK_B1D98384584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE detail_purchase_order ADD CONSTRAINT FK_B1D9838A45D7E6A FOREIGN KEY (purchase_order_id) REFERENCES purchase_order (id)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD8DE820D9 FOREIGN KEY (seller_id) REFERENCES enterprise (id)');
        $this->addSql('ALTER TABLE purchase_order ADD CONSTRAINT FK_21E210B26C755722 FOREIGN KEY (buyer_id) REFERENCES enterprise (id)');
        $this->addSql('ALTER TABLE purchase_order ADD CONSTRAINT FK_21E210B28DE820D9 FOREIGN KEY (seller_id) REFERENCES enterprise (id)');
        $this->addSql('ALTER TABLE shipment ADD CONSTRAINT FK_2CB20DC547BC3E6 FOREIGN KEY (acceptance_order_id) REFERENCES acceptance_order (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE detail_acceptance_order DROP FOREIGN KEY FK_60B2650A547BC3E6');
        $this->addSql('ALTER TABLE shipment DROP FOREIGN KEY FK_2CB20DC547BC3E6');
        $this->addSql('ALTER TABLE acceptance_order DROP FOREIGN KEY FK_42BD34268DE820D9');
        $this->addSql('ALTER TABLE acceptance_order DROP FOREIGN KEY FK_42BD34266C755722');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD8DE820D9');
        $this->addSql('ALTER TABLE purchase_order DROP FOREIGN KEY FK_21E210B26C755722');
        $this->addSql('ALTER TABLE purchase_order DROP FOREIGN KEY FK_21E210B28DE820D9');
        $this->addSql('ALTER TABLE detail_acceptance_order DROP FOREIGN KEY FK_60B2650A4584665A');
        $this->addSql('ALTER TABLE detail_purchase_order DROP FOREIGN KEY FK_B1D98384584665A');
        $this->addSql('ALTER TABLE acceptance_order DROP FOREIGN KEY FK_42BD3426A45D7E6A');
        $this->addSql('ALTER TABLE detail_purchase_order DROP FOREIGN KEY FK_B1D9838A45D7E6A');
        $this->addSql('DROP TABLE acceptance_order');
        $this->addSql('DROP TABLE detail_acceptance_order');
        $this->addSql('DROP TABLE detail_purchase_order');
        $this->addSql('DROP TABLE enterprise');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE purchase_order');
        $this->addSql('DROP TABLE shipment');
    }
}
