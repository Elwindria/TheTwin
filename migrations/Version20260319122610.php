<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260319122610 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE challenge (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(500) DEFAULT NULL, difficulty VARCHAR(50) NOT NULL, category_id INT NOT NULL, INDEX IDX_D709895112469DE2 (category_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE challenge_eco_action (challenge_id INT NOT NULL, eco_action_id INT NOT NULL, INDEX IDX_FBE2055298A21AC6 (challenge_id), INDEX IDX_FBE20552B36CCA97 (eco_action_id), PRIMARY KEY (challenge_id, eco_action_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE challenge_eco_action_variant (challenge_id INT NOT NULL, eco_action_variant_id INT NOT NULL, INDEX IDX_A4585E0998A21AC6 (challenge_id), INDEX IDX_A4585E09F4C5216A (eco_action_variant_id), PRIMARY KEY (challenge_id, eco_action_variant_id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE challenge ADD CONSTRAINT FK_D709895112469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE challenge_eco_action ADD CONSTRAINT FK_FBE2055298A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_eco_action ADD CONSTRAINT FK_FBE20552B36CCA97 FOREIGN KEY (eco_action_id) REFERENCES eco_action (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_eco_action_variant ADD CONSTRAINT FK_A4585E0998A21AC6 FOREIGN KEY (challenge_id) REFERENCES challenge (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE challenge_eco_action_variant ADD CONSTRAINT FK_A4585E09F4C5216A FOREIGN KEY (eco_action_variant_id) REFERENCES eco_action_variant (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE challenge DROP FOREIGN KEY FK_D709895112469DE2');
        $this->addSql('ALTER TABLE challenge_eco_action DROP FOREIGN KEY FK_FBE2055298A21AC6');
        $this->addSql('ALTER TABLE challenge_eco_action DROP FOREIGN KEY FK_FBE20552B36CCA97');
        $this->addSql('ALTER TABLE challenge_eco_action_variant DROP FOREIGN KEY FK_A4585E0998A21AC6');
        $this->addSql('ALTER TABLE challenge_eco_action_variant DROP FOREIGN KEY FK_A4585E09F4C5216A');
        $this->addSql('DROP TABLE challenge');
        $this->addSql('DROP TABLE challenge_eco_action');
        $this->addSql('DROP TABLE challenge_eco_action_variant');
    }
}
