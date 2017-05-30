<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170415161442 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE moviments_id_seq CASCADE');
        $this->addSql('DROP TABLE moviments');
        $this->addSql('DROP INDEX email_idx');
        $this->addSql('ALTER TABLE usuari ALTER id TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE usuari ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE usuari ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE usuari ALTER email TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE usuari ALTER full_name TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE usuari ALTER password TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE usuari ALTER status TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE usuari ALTER status DROP DEFAULT');
        $this->addSql('ALTER TABLE usuari ALTER date_created TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE usuari ALTER date_created DROP DEFAULT');
        $this->addSql('ALTER TABLE usuari ALTER pwd_reset_token SET NOT NULL');
        $this->addSql('ALTER TABLE usuari ALTER pwd_reset_token TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE usuari ALTER pwd_reset_token_creation_date TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE usuari ALTER pwd_reset_token_creation_date DROP DEFAULT');
        $this->addSql('ALTER TABLE usuari ALTER pwd_reset_token_creation_date SET NOT NULL');
        $this->addSql('DROP INDEX "primary"');
        $this->addSql('ALTER TABLE comptes ALTER id DROP DEFAULT');
        $this->addSql('ALTER TABLE comptes ADD PRIMARY KEY (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE moviments_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE moviments (id SERIAL NOT NULL, codi_d INT NOT NULL, codi_h INT NOT NULL, data TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, import INT NOT NULL, concepte TEXT DEFAULT NULL, responsable TEXT DEFAULT NULL, date_created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX codi_h_index ON moviments (codi_h)');
        $this->addSql('CREATE INDEX data_index ON moviments (data)');
        $this->addSql('CREATE INDEX codi_d_index ON moviments (codi_d)');
        $this->addSql('ALTER TABLE moviments ADD CONSTRAINT moviments_codi_d_comptes_fk FOREIGN KEY (codi_d) REFERENCES comptes (codi) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE moviments ADD CONSTRAINT moviments_codi_h_comptes_fk FOREIGN KEY (codi_h) REFERENCES comptes (codi) ON UPDATE CASCADE ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE usuari ALTER id TYPE SERIAL');
        $this->addSql('ALTER TABLE usuari ALTER id DROP DEFAULT');
        $this->addSql('CREATE SEQUENCE usuari_id_seq');
        $this->addSql('SELECT setval(\'usuari_id_seq\', (SELECT MAX(id) FROM usuari))');
        $this->addSql('ALTER TABLE usuari ALTER id SET DEFAULT nextval(\'usuari_id_seq\')');
        $this->addSql('ALTER TABLE usuari ALTER email TYPE VARCHAR(128)');
        $this->addSql('ALTER TABLE usuari ALTER full_name TYPE VARCHAR(512)');
        $this->addSql('ALTER TABLE usuari ALTER password TYPE VARCHAR(256)');
        $this->addSql('ALTER TABLE usuari ALTER status TYPE INT');
        $this->addSql('ALTER TABLE usuari ALTER status DROP DEFAULT');
        $this->addSql('ALTER TABLE usuari ALTER date_created TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE usuari ALTER date_created DROP DEFAULT');
        $this->addSql('ALTER TABLE usuari ALTER pwd_reset_token DROP NOT NULL');
        $this->addSql('ALTER TABLE usuari ALTER pwd_reset_token TYPE VARCHAR(32)');
        $this->addSql('ALTER TABLE usuari ALTER pwd_reset_token_creation_date TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('ALTER TABLE usuari ALTER pwd_reset_token_creation_date DROP DEFAULT');
        $this->addSql('ALTER TABLE usuari ALTER pwd_reset_token_creation_date DROP NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX email_idx ON usuari (email)');
        $this->addSql('DROP INDEX comptes_pkey');
        $this->addSql('CREATE SEQUENCE comptes_id_seq');
        $this->addSql('SELECT setval(\'comptes_id_seq\', (SELECT MAX(id) FROM comptes))');
        $this->addSql('ALTER TABLE comptes ALTER id SET DEFAULT nextval(\'comptes_id_seq\')');
        $this->addSql('ALTER TABLE comptes ADD PRIMARY KEY (codi)');
    }
}
