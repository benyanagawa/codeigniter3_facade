<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_create_test extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field([
            'id' => [
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => true,
                    'auto_increment' => true
            ],
            'name' => [
                    'type' => 'VARCHAR',
                    'constraint' => '100'
            ],
            'discription' => [
                    'type' => 'TEXT',
                    'null' => true
            ],
        ]);
        $this->dbforge->add_key('id', true);
        $this->dbforge->create_table('test');
    }

    public function down()
    {
            $this->dbforge->drop_table('test');
    }
}
