<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230411225546 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Removing unique index as multiple users can have same fruit as favorite';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favorite_fruits DROP INDEX UNIQ_4970AEC4BAC115F0, ADD INDEX IDX_4970AEC4BAC115F0 (fruit_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE favorite_fruits DROP INDEX IDX_4970AEC4BAC115F0, ADD UNIQUE INDEX UNIQ_4970AEC4BAC115F0 (fruit_id)');
    }
}
