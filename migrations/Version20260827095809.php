<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260827095809 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE month (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, num INT NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE postal_code (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(5) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE tip (id INT AUTO_INCREMENT NOT NULL, content VARCHAR(255) NOT NULL, user_id INT NOT NULL, INDEX IDX_4883B84CA76ED395 (user_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE tip_month (tip_id INT NOT NULL, month_id INT NOT NULL, INDEX IDX_DDC6B0F5476C47F6 (tip_id), INDEX IDX_DDC6B0F5A0CBDE4 (month_id), PRIMARY KEY (tip_id, month_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, postal_code_id INT NOT NULL, INDEX IDX_8D93D649BDBA6A61 (postal_code_id), UNIQUE INDEX UNIQ_IDENTIFIER_LOGIN (login), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('CREATE TABLE weather_mesurement (id INT AUTO_INCREMENT NOT NULL, temperature DOUBLE PRECISION NOT NULL, mesured_at DATETIME NOT NULL, postal_code_id INT NOT NULL, INDEX IDX_CE6C24DBBDBA6A61 (postal_code_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE tip ADD CONSTRAINT FK_4883B84CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tip_month ADD CONSTRAINT FK_DDC6B0F5476C47F6 FOREIGN KEY (tip_id) REFERENCES tip (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE tip_month ADD CONSTRAINT FK_DDC6B0F5A0CBDE4 FOREIGN KEY (month_id) REFERENCES month (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BDBA6A61 FOREIGN KEY (postal_code_id) REFERENCES postal_code (id)');
        $this->addSql('ALTER TABLE weather_mesurement ADD CONSTRAINT FK_CE6C24DBBDBA6A61 FOREIGN KEY (postal_code_id) REFERENCES postal_code (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tip DROP FOREIGN KEY FK_4883B84CA76ED395');
        $this->addSql('ALTER TABLE tip_month DROP FOREIGN KEY FK_DDC6B0F5476C47F6');
        $this->addSql('ALTER TABLE tip_month DROP FOREIGN KEY FK_DDC6B0F5A0CBDE4');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BDBA6A61');
        $this->addSql('ALTER TABLE weather_mesurement DROP FOREIGN KEY FK_CE6C24DBBDBA6A61');
        $this->addSql('DROP TABLE month');
        $this->addSql('DROP TABLE postal_code');
        $this->addSql('DROP TABLE tip');
        $this->addSql('DROP TABLE tip_month');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE weather_mesurement');
    }
}
