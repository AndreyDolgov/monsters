<?php
/**
 * Created by PhpStorm.
 * User: Maxmyd
 * Date: 23.01.2018
 * Time: 22:15
 * Tha base class of game rooms
 */


class Room_base extends CI_Model
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

    /**
     * @var varchar $table_name - room table name
     */
    protected $table_name;

    /**
     * @var int $room_type - room type index
     */
    protected $room_type;

    public function __construct()
    {
        parent::__construct();
    }

    //упрощенная версия
    //должны быть проверки на протухшую сессию, на возможность создания одим пользователем множества сессий и т.д.
    public function check_room_exist($user_1_id,$user_2_id){

        $res = $this->db->select('session_id')
            ->from($this->table_name)
            ->where(array(
                'room_type'=>$this->room_type,
                'user_1_id'=>$user_1_id,
                'user_2_id'=>$user_2_id,
            ))
            ->where('status !='. ROOM_STATUS_CLOSED)
            ->get()
            ->result();

        return (count($res) > 0)? $res[0]->session_id:false;
    }

    public function make_room($user_1_id,$user_2_id){
        $_session_id = time() .'_'. $user_1_id .'_'. $user_2_id;
        $_id = $this->db->insert($this->table_name, array(
            'session_id'=>$_session_id,
            'user_1_id'=>$user_1_id,
            'user_2_id'=>$user_2_id,
            'status'=>ROOM_STATUS_NEW,
            'room_type'=>$this->room_type,
        ));

        return $_session_id;

    }

    public function close_room($session_id,$status,$winner){

        $this->db->where(array('session_id' => $session_id))->update($this->table_name,array('status'=>$status,'winner_id'=>$winner,'closed_at'=>'now()'));
    }

}