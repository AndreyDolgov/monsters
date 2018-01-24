<?php
/**
 * Created by PhpStorm.
 * User: Maxmyd
 * Date: 23.01.2018
 * Time: 22:15
 * Tha base class of game rooms
 */


abstract class Room_base extends CI_Model
{
    /**
     * @var int $count_of_users - how many users can be in room
     */
    protected $count_of_users;

    /**
     * @var int $count_of_monsters - hove many monsters every room`s user can use in room
     */
    protected $count_of_monsters;

    /**
     * @var int $wait_time - seconds. how many time room will wait for out user
     */
    protected $wait_time;

    /**
     * @var array $users_in_room - how many users in room in this moment
     */
    protected $users_in_room = [];

    /**
     * @var boolean $has_ai - flag, has room AI or not
     */
    protected $has_ai;

    public function __construct()
    {
        parent::__construct();
    }
}