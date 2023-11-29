<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231127095411 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("CREATE TABLE `user` (
                            `id` INT(11) NOT NULL AUTO_INCREMENT,
                            `username` VARCHAR(25) NOT NULL COLLATE 'utf8_unicode_ci',
                            `password` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
                            `email` VARCHAR(255) NOT NULL COLLATE 'utf8_unicode_ci',
                            `roles` LONGTEXT NOT NULL COMMENT '(DC2Type:array)' COLLATE 'utf8_unicode_ci',
                            PRIMARY KEY (`id`) USING BTREE
                        )
                        COLLATE='utf8_unicode_ci'
                        ENGINE=InnoDB
                        AUTO_INCREMENT=0
                        ;");

        $this->addSql("CREATE TABLE `messenger_messages` (
                        `id` INT(11) NOT NULL AUTO_INCREMENT,
                        `headers` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
                        `body` MEDIUMTEXT NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
                        `queue_name` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
                        `created_at` DATETIME NULL DEFAULT NULL,
                        `available_at` DATETIME NULL DEFAULT NULL,
                        PRIMARY KEY (`id`) USING BTREE
                    )
                    COLLATE='utf8mb4_general_ci'
                    ENGINE=InnoDB
                    AUTO_INCREMENT=0;");

        $this->addSql("CREATE TABLE `blog` (
                            `id` INT(11) NOT NULL AUTO_INCREMENT,
                            `user_id` INT(11) NOT NULL DEFAULT '0',
                            `title` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
                            `comment` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
                            `description` VARCHAR(255) NULL DEFAULT NULL COLLATE 'utf8mb4_general_ci',
                            `created_at` DATETIME NULL DEFAULT NULL,
                            `updated_at` DATETIME NULL DEFAULT NULL,
                            PRIMARY KEY (`id`) USING BTREE,
                            INDEX `FK_blog_user` (`user_id`) USING BTREE
                        )
                        COLLATE='utf8mb4_general_ci'
                        ENGINE=InnoDB
                        AUTO_INCREMENT=21
                        ;");


    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
