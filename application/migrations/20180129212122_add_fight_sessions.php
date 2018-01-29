<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_fight_sessions extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'room_type' => array(
                'type' => 'VARCHAR',
                'constraint' => '20'
            ),
            'session_id' => array(
                'type' => 'VARCHAR',
                'constraint' => '40'
            ),
            'session_data' => array(
                'type' => 'LONGTEXT',
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('fight_sessions');
    }

    public function down()
    {
        $this->dbforge->drop_table('fight_sessions');
    }
}