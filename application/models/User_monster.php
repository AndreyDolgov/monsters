<?php
/**
 * Created by PhpStorm.
 * User: Maxmyd
 * Date: 23.01.2018
 * Time: 22:15
 * Tha base class of game rooms
 */


class User_monster extends CI_Model
{

    /**
     * @var varchar $table_name - table name
     */
    protected $table_name = 'users_monsters';


    public function __construct()
    {
        parent::__construct();
    }


    public function get_fight_monsters($user_id){

        $res = $this->db->order_by('order')->get_where($this->table_name,array('user_id'=>$user_id))->result_array();

        if(count($res) == 0){
            error('No monsters for user'. $user_id);
        }

        foreach ($res as $monster){

            $monster_full_info = $this->monster->get_full_info($monster['monster_id']);
            $data[$monster['monster_id']] = array_merge($monster,$monster_full_info);
        }

        return $data;
    }



}