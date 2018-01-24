<?php
/**
 * Created by PhpStorm.
 * User: Maxmyd
 * Date: 23.01.2018
 * Time: 22:32
 */

require_once APPPATH.'models/base/pvp_room.php';

class Fight_room_duel extends Pvp_room
{
    public function __construct()
    {
        parent::__construct();
        $this->count_of_users = 2;
        $this->count_of_monsters = 1;
        $this->wait_time = 30;
    }
}