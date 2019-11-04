<?php

declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20191104104633 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Document and status (draft, published) tables';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql("CREATE TABLE IF NOT EXISTS `document` (
          `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
          `uuid` varchar(36) NOT NULL,
          `payload` longtext NOT NULL CHECK (json_valid(`payload`)),
          `createAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
          `modifyAt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
          PRIMARY KEY (`id`),
          UNIQUE KEY `uuid` (`uuid`)
        ) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;");

        $this->addSql("CREATE TABLE IF NOT EXISTS `document_draft` (
          `document_ptr_id` int(10) unsigned NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

        $this->addSql("CREATE TABLE IF NOT EXISTS `document_publish` (
          `document_ptr_id` int(10) unsigned NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
    }

    public function down(Schema $schema) : void
    {
        $this->addSql("DROP TABLE `document_publish`;");
        $this->addSql("DROP TABLE `document_draft`;");
        $this->addSql("DROP TABLE `document`;");
    }
}
