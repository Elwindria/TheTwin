<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260313191517 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE eco_action (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, category_id INT NOT NULL, INDEX IDX_9BF21C5B12469DE2 (category_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE eco_action_variant (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, co2_saved NUMERIC(10, 2) NOT NULL, twin_co2_produced NUMERIC(10, 2) NOT NULL, score INT NOT NULL, eco_action_id INT NOT NULL, INDEX IDX_D3B5E9E9B36CCA97 (eco_action_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user_action (id INT AUTO_INCREMENT NOT NULL, score INT NOT NULL, final_co2_saved NUMERIC(10, 2) NOT NULL, final_twin_co2_produced NUMERIC(10, 2) NOT NULL, created_at DATETIME NOT NULL, is_available TINYINT NOT NULL, user_id INT NOT NULL, category_id INT NOT NULL, eco_action_id INT NOT NULL, eco_action_variant_id INT NOT NULL, INDEX IDX_229E97AFA76ED395 (user_id), INDEX IDX_229E97AF12469DE2 (category_id), INDEX IDX_229E97AFB36CCA97 (eco_action_id), INDEX IDX_229E97AFF4C5216A (eco_action_variant_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE eco_action ADD CONSTRAINT FK_9BF21C5B12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE eco_action_variant ADD CONSTRAINT FK_D3B5E9E9B36CCA97 FOREIGN KEY (eco_action_id) REFERENCES eco_action (id)');
        $this->addSql('ALTER TABLE user_action ADD CONSTRAINT FK_229E97AFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_action ADD CONSTRAINT FK_229E97AF12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE user_action ADD CONSTRAINT FK_229E97AFB36CCA97 FOREIGN KEY (eco_action_id) REFERENCES eco_action (id)');
        $this->addSql('ALTER TABLE user_action ADD CONSTRAINT FK_229E97AFF4C5216A FOREIGN KEY (eco_action_variant_id) REFERENCES eco_action_variant (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE eco_action DROP FOREIGN KEY FK_9BF21C5B12469DE2');
        $this->addSql('ALTER TABLE eco_action_variant DROP FOREIGN KEY FK_D3B5E9E9B36CCA97');
        $this->addSql('ALTER TABLE user_action DROP FOREIGN KEY FK_229E97AFA76ED395');
        $this->addSql('ALTER TABLE user_action DROP FOREIGN KEY FK_229E97AF12469DE2');
        $this->addSql('ALTER TABLE user_action DROP FOREIGN KEY FK_229E97AFB36CCA97');
        $this->addSql('ALTER TABLE user_action DROP FOREIGN KEY FK_229E97AFF4C5216A');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE eco_action');
        $this->addSql('DROP TABLE eco_action_variant');
        $this->addSql('DROP TABLE user_action');
    }
}
