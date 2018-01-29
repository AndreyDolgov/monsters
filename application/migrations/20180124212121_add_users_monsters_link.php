<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_users_monsters_link extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'user_id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
            ),
            'monster_id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
            ),
            'monster_lvl' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
            ),
            'monster_exp' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
            ),
            'monster_name' => array(
                'type' => 'TEXT',
                'constraint' => '100'
            ),
            'order' => array(
                'type' => 'INT',
                'constraint' => 5,
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('users_monsters');

        $this->db->query("INSERT INTO `users_monsters` (`id`, `user_id`, `monster_id`, `monster_lvl`, `monster_exp`, `monster_name`) VALUES (NULL, '1', '62818', '1', '0', 'kizil'), (NULL, '1', '7560', '1', '0', '');");
        $this->db->query(" INSERT INTO `users_monsters` (`id`, `user_id`, `monster_id`, `monster_lvl`, `monster_exp`, `monster_name`) VALUES (NULL, '1', '62178', '1', '0', ''), (NULL, '2', '61369', '1', '0', '');");
        $this->db->query("INSERT INTO `users_monsters` (`id`, `user_id`, `monster_id`, `monster_lvl`, `monster_exp`, `monster_name`) VALUES (NULL, '2', '14421', '1', '0', ''), (NULL, '2', '61141', '1', '0', 'baltazar');");

    }

    public function down()
    {
        $this->dbforge->drop_table('users_monsters');
    }
}