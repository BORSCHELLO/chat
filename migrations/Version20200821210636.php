<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200821210636 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql("
            CREATE TABLE room (
                 id int(11) NOT NULL AUTO_INCREMENT,
                 user_id int(11) DEFAULT NULL COMMENT 'Идентификатор пользователя которому принадлежит комната',
                 title varchar(50) NOT NULL COMMENT 'Название комнаты', 
                 public tinyint(1) DEFAULT '1' NOT NULL COMMENT 'Публичная комната',
                 enabled tinyint(1) DEFAULT '1' NOT NULL COMMENT 'Активная комната',
                 PRIMARY KEY (id)
            )"
        );

        $this->addSql('DELETE FROM user WHERE id = 1');
        $this->addSql('INSERT INTO user (id, name) VALUES (1, "admin")');

        $this->addSql(
            'INSERT INTO room (id, user_id, title, public, enabled) VALUES(1, 1, "главная", 1, 1)'
        );

        $this->addSql('ALTER TABLE message ADD COLUMN room_id int NOT NULL COMMENT "Идентификатор комнаты"');
        $this->addSql('UPDATE message SET room_id = 1');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql('DROP TABLE room');
        $this->addSql('ALTER TABLE message DROP COLUMN room_id');
    }
}
