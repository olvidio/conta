<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170415163816 extends AbstractMigration
{
	/**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // Add index to comptes table
        $table = $schema->getTable('comptes');
        $table->addIndex(['codi'], 'comptes_codi_index');

        // Add index and foreign key to moviemnts table
        $table = $schema->getTable('moviments');
        $table->addForeignKeyConstraint('comptes', ['codi'], ['codi_d'], [], 'moviments_comptes_codi_d_fk');
        $table->addForeignKeyConstraint('comptes', ['codi'], ['codi_h'], [], 'moviments_comptes_codi_h_fk');

    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {

        $table = $schema->getTable('comptes');
		$table->dropIndex('comptes_codi_index');

        $table = $schema->getTable('moviments');
		$table->removeForeignKey('moviments_comptes_codi_d_fk');
		$table->removeForeignKey('moviments_comptes_codi_h_fk');
    }
}
