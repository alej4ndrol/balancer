<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220821091957 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE process_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE work_machine_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE process (id INT NOT NULL, work_machine_id INT NOT NULL, name VARCHAR(255) NOT NULL, processor INT NOT NULL, ram INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_861D18965E237E06 ON process (name)');
        $this->addSql('CREATE INDEX IDX_861D1896EDD4F6F5 ON process (work_machine_id)');
        $this->addSql('CREATE TABLE work_machine (id INT NOT NULL, name VARCHAR(255) NOT NULL, processor INT NOT NULL, ram INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C0CE67A65E237E06 ON work_machine (name)');
        $this->addSql('ALTER TABLE process ADD CONSTRAINT FK_861D1896EDD4F6F5 FOREIGN KEY (work_machine_id) REFERENCES work_machine (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE process_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE work_machine_id_seq CASCADE');
        $this->addSql('ALTER TABLE process DROP CONSTRAINT FK_861D1896EDD4F6F5');
        $this->addSql('DROP TABLE process');
        $this->addSql('DROP TABLE work_machine');
    }
}
