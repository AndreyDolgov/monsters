<?php
/**
 * Created by PhpStorm.
 * User: Maxmyd
 * Date: 23.01.2018
 * Time: 22:37
 */


require_once APPPATH.'models/base/room_base.php';

class Pve_room extends Room_base
{
    /**
     * @var $ai_model - what of different ai models room will use
     */
    protected $ai_model;

    public function __construct()
    {
        $this->has_ai = true;
    }
}