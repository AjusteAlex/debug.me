<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231212135927 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gamification CHANGE level score INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD badge_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F7A2C2FC FOREIGN KEY (badge_id) REFERENCES gamification (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649F7A2C2FC ON user (badge_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gamification CHANGE score level INT NOT NULL');
        $this->addSql('ALTER TABLE `user` DROP FOREIGN KEY FK_8D93D649F7A2C2FC');
        $this->addSql('DROP INDEX IDX_8D93D649F7A2C2FC ON `user`');
        $this->addSql('ALTER TABLE `user` DROP badge_id');
    }
}
