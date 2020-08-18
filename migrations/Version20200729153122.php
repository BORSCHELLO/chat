<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200729153122 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('
            CREATE TABLE message (
                id INT AUTO_INCREMENT NOT NULL, 
                message VARCHAR(1000) NOT NULL, 
                created_at DATETIME NOT NULL, 
                PRIMARY KEY(id)
            ) ENGINE = InnoDB'
        );
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE message');
    }
}
