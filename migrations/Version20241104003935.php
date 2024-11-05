<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241104003935 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE environnement (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visite_environnement (visite_id INT NOT NULL, environnement_id INT NOT NULL, INDEX IDX_6690F746C1C5DC59 (visite_id), INDEX IDX_6690F746BAFB82A1 (environnement_id), PRIMARY KEY(visite_id, environnement_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE visite_environnement ADD CONSTRAINT FK_6690F746C1C5DC59 FOREIGN KEY (visite_id) REFERENCES visite (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE visite_environnement ADD CONSTRAINT FK_6690F746BAFB82A1 FOREIGN KEY (environnement_id) REFERENCES environnement (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE ville');
        $this->addSql('ALTER TABLE visite ADD image_name VARCHAR(255) DEFAULT NULL, ADD image_size INT DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', ADD tempmin INT DEFAULT NULL, ADD tempmax INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, ville VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE visite_environnement DROP FOREIGN KEY FK_6690F746C1C5DC59');
        $this->addSql('ALTER TABLE visite_environnement DROP FOREIGN KEY FK_6690F746BAFB82A1');
        $this->addSql('DROP TABLE environnement');
        $this->addSql('DROP TABLE visite_environnement');
        $this->addSql('ALTER TABLE visite DROP image_name, DROP image_size, DROP updated_at, DROP tempmin, DROP tempmax');
    }
}
