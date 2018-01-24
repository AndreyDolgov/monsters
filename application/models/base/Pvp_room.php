<?php
/**
 * Created by PhpStorm.
 * User: Maxmyd
 * Date: 23.01.2018
 * Time: 22:37
 */


require_once APPPATH.'models/base/room_base.php';

class Pvp_room extends Room_base
{
    public function __construct()
    {
        parent::__construct();
        $this->has_ai = false;
    }
}