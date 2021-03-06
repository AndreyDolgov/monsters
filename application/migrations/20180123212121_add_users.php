<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_users extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => TRUE,
                'auto_increment' => TRUE
            ),
            'user_name' => array(
                'type' => 'VARCHAR',
                'constraint' => '100'
            ),
            'user_password' => array(
                'type' => 'TEXT',
                'constraint' => '100'
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('users');
        $this->db->query("INSERT INTO `users` (`id`, `user_name`, `user_password`) VALUES (NULL, 'adam', ''), (NULL, 'eva', '');");
    }

    public function down()
    {
        $this->dbforge->drop_table('users');
    }
}