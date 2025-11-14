<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251114085342 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accessoire (id INT AUTO_INCREMENT NOT NULL, nom_accessoire VARCHAR(255) NOT NULL, type_accessoire VARCHAR(255) NOT NULL, prix_accessoire INT NOT NULL, visuel_accessoire VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, argent_possede INT NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_possession (utilisateur_id INT NOT NULL, accessoire_id INT NOT NULL, INDEX IDX_CB56FD54FB88E14F (utilisateur_id), INDEX IDX_CB56FD54D23B67ED (accessoire_id), PRIMARY KEY(utilisateur_id, accessoire_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur_tenue_portee (utilisateur_id INT NOT NULL, accessoire_id INT NOT NULL, INDEX IDX_8BB8A846FB88E14F (utilisateur_id), INDEX IDX_8BB8A846D23B67ED (accessoire_id), PRIMARY KEY(utilisateur_id, accessoire_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE utilisateur_possession ADD CONSTRAINT FK_CB56FD54FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE utilisateur_possession ADD CONSTRAINT FK_CB56FD54D23B67ED FOREIGN KEY (accessoire_id) REFERENCES accessoire (id)');
        $this->addSql('ALTER TABLE utilisateur_tenue_portee ADD CONSTRAINT FK_8BB8A846FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)');
        $this->addSql('ALTER TABLE utilisateur_tenue_portee ADD CONSTRAINT FK_8BB8A846D23B67ED FOREIGN KEY (accessoire_id) REFERENCES accessoire (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur_possession DROP FOREIGN KEY FK_CB56FD54FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_possession DROP FOREIGN KEY FK_CB56FD54D23B67ED');
        $this->addSql('ALTER TABLE utilisateur_tenue_portee DROP FOREIGN KEY FK_8BB8A846FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_tenue_portee DROP FOREIGN KEY FK_8BB8A846D23B67ED');
        $this->addSql('DROP TABLE accessoire');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE utilisateur_possession');
        $this->addSql('DROP TABLE utilisateur_tenue_portee');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
