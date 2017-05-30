<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170415153816 extends AbstractMigration
{
	/**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
		// Create 'moviments' table
        $table = $schema->createTable('moviments');
        $table->addColumn('id', 'integer', ['autoincrement'=>true]);
        $table->addColumn('data', 'datetime', ['notnull'=>true]);
        $table->addColumn('import', 'integer', ['notnull'=>true]);
        $table->addColumn('codi_d', 'integer', ['notnull'=>true]);
        $table->addColumn('codi_h', 'integer', ['notnull'=>true]);
        $table->addColumn('concepte', 'text');
        $table->addColumn('responsable', 'text');
        $table->addColumn('date_created', 'datetime', ['notnull'=>true]);
        $table->setPrimaryKey(['id']);

        $table->addIndex(['data'], 'data_index');
        $table->addIndex(['codi_d'], 'codi_d_index');
        $table->addIndex(['codi_h'], 'codi_h_index');
        
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

        $table = $schema->getTable('moviments');
        $table->dropIndex('data_index');
        $table->dropIndex('codi_d_index');
        $table->dropIndex('codi_h_index');
        // this down() migration is auto-generated, please modify it to your needs
		$schema->dropTable('moviments');
		
    }
}
