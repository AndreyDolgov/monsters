<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_fight_room_users extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'fight_room_id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
            ),
            'user_id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
            ),

        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('fight_room_users');
    }

    public function down()
    {
        $this->dbforge->drop_table('fight_room_users');
    }
}