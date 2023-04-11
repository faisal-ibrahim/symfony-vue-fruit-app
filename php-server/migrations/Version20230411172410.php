<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230411172410 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE favorite_fruits (id INT AUTO_INCREMENT NOT NULL, fruit_id INT NOT NULL, user_id INT NOT NULL, UNIQUE INDEX UNIQ_4970AEC4BAC115F0 (fruit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fruit (id INT AUTO_INCREMENT NOT NULL, fruityvice_id INT NOT NULL, name VARCHAR(255) NOT NULL, family VARCHAR(255) NOT NULL, fruit_order VARCHAR(255) NOT NULL, genus VARCHAR(255) NOT NULL, calories DOUBLE PRECISION NOT NULL, fat DOUBLE PRECISION NOT NULL, sugar DOUBLE PRECISION NOT NULL, carbohydrates DOUBLE PRECISION NOT NULL, protein DOUBLE PRECISION NOT NULL, nutrition_sum DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_A00BD2973EED380E (fruityvice_id), INDEX fruityvice_id_index (fruityvice_id), INDEX name_index (name), INDEX family_index (family), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE favorite_fruits ADD CONSTRAINT FK_4970AEC4BAC115F0 FOREIGN KEY (fruit_id) REFERENCES fruit (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favorite_fruits DROP FOREIGN KEY FK_4970AEC4BAC115F0');
        $this->addSql('DROP TABLE favorite_fruits');
        $this->addSql('DROP TABLE fruit');
    }
}
