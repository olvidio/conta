<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170531095813 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE comptes_dsa_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE comptes_id_seq CASCADE');
        $this->addSql('DROP TABLE comptes_dsa');
        $this->addSql('CREATE SEQUENCE comptes_codi_seq');
        $this->addSql('SELECT setval(\'comptes_codi_seq\', (SELECT MAX(codi) FROM comptes))');
        $this->addSql('ALTER TABLE comptes ALTER codi SET DEFAULT nextval(\'comptes_codi_seq\')');
        $this->addSql('ALTER TABLE comptes ALTER id DROP DEFAULT');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE comptes_dsa_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE comptes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE comptes_dsa (codi INT NOT NULL, id SERIAL NOT NULL, nom TEXT NOT NULL, explicacio TEXT NOT NULL, codi_alternatiu INT NOT NULL, tipus INT NOT NULL, status INT NOT NULL, date_created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(codi))');
        $this->addSql('ALTER TABLE comptes ALTER codi DROP DEFAULT');
        $this->addSql('CREATE SEQUENCE comptes_id_seq');
        $this->addSql('SELECT setval(\'comptes_id_seq\', (SELECT MAX(id) FROM comptes))');
        $this->addSql('ALTER TABLE comptes ALTER id SET DEFAULT nextval(\'comptes_id_seq\')');
    }
}
