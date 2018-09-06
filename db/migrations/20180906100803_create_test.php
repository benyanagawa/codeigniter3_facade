<?php


use Phinx\Migration\AbstractMigration;

class CreateTest extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */

	function change()
    {
        $query = <<<EOQ
CREATE TABLE IF NOT EXISTS `test` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `test_str` varchar(255) default NULL,
  `test_int` integer,
  `created` datetime default NULL,
  `modified` datetime default NULL,
  PRIMARY KEY  (`id`)
)AUTO_INCREMENT=1 ;
EOQ;
        $this->execute($query);
    }

	public function up()
	{

	}

    public function down()
    {

    }
}
