<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_fight_rooms extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'session_id' => array(
                'type' => 'VARCHAR',
                'constraint' => '40'
            ),
            'user_1_id' => array(
                'constraint' => 5,
                'unsigned' => TRUE,
            ),
            'user_2_id' => array(
                'constraint' => 5,
                'unsigned' => TRUE,
            ),
            'status' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
            ),
            'room_type' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
            ),
            'round_number' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
            ),
            'winner_id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
            ),
            'create_at' => array(
                'type' => 'Timestamp',
            ),
            'closed_at' => array(
                'type' => 'Timestamp',
            ),

        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('fight_rooms');
    }

    public function down()
    {
        $this->dbforge->drop_table('fight_rooms');
    }
}