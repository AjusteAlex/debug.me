<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231124135527 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE level (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, min_points INT NOT NULL, max_points INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql("INSERT INTO level (name, min_points, max_points) VALUES ('Apprenti', 0, 10)");
        $this->addSql("INSERT INTO level (name, min_points, max_points) VALUES ('Développeur en Herbe', 11, 30)");
        $this->addSql("INSERT INTO level (name, min_points, max_points) VALUES ('Codeur Confirmé', 31, 50)");
        $this->addSql("INSERT INTO level (name, min_points, max_points) VALUES ('Expert en Résolution', 51, 100)");

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE level');
    }
}
