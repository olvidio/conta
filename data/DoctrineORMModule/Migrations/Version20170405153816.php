<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170405153816 extends AbstractMigration
{
	/**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
		// Create 'post' table
        $table = $schema->createTable('comptes');
        $table->addColumn('id', 'integer', ['autoincrement'=>true]);
        $table->addColumn('codi', 'integer', ['notnull'=>true]);
        $table->addColumn('nom', 'text', ['notnull'=>true]);
        $table->addColumn('explicacio', 'text');
        $table->addColumn('codi_alternatiu', 'integer');
        $table->addColumn('tipus', 'integer', ['notnull'=>true]);
        $table->addColumn('status', 'integer', ['notnull'=>true]);
        $table->addColumn('date_created', 'datetime', ['notnull'=>true]);
        $table->setPrimaryKey(['codi']);

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
		$schema->dropTable('comptes');
		
    }
}