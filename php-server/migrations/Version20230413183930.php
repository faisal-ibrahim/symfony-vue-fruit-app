<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230413183930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE favorite_fruit (id INT AUTO_INCREMENT NOT NULL, fruit_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_1683F9B3BAC115F0 (fruit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE favorite_fruit ADD CONSTRAINT FK_1683F9B3BAC115F0 FOREIGN KEY (fruit_id) REFERENCES fruit (id)');
        $this->addSql('ALTER TABLE favorite_fruits DROP FOREIGN KEY FK_4970AEC4BAC115F0');
        $this->addSql('DROP TABLE favorite_fruits');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE favorite_fruits (id INT AUTO_INCREMENT NOT NULL, fruit_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_4970AEC4BAC115F0 (fruit_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE favorite_fruits ADD CONSTRAINT FK_4970AEC4BAC115F0 FOREIGN KEY (fruit_id) REFERENCES fruit (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE favorite_fruit DROP FOREIGN KEY FK_1683F9B3BAC115F0');
        $this->addSql('DROP TABLE favorite_fruit');
    }
}
