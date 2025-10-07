<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251007065009 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE player ADD niveau_id INT DEFAULT NULL, ADD categorie_sportive_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A65B3E9C81 FOREIGN KEY (niveau_id) REFERENCES level (id)');
        $this->addSql('ALTER TABLE player ADD CONSTRAINT FK_98197A659CE95AC1 FOREIGN KEY (categorie_sportive_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_98197A65B3E9C81 ON player (niveau_id)');
        $this->addSql('CREATE INDEX IDX_98197A659CE95AC1 ON player (categorie_sportive_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A65B3E9C81');
        $this->addSql('ALTER TABLE player DROP FOREIGN KEY FK_98197A659CE95AC1');
        $this->addSql('DROP INDEX IDX_98197A65B3E9C81 ON player');
        $this->addSql('DROP INDEX IDX_98197A659CE95AC1 ON player');
        $this->addSql('ALTER TABLE player DROP niveau_id, DROP categorie_sportive_id');
    }
}
