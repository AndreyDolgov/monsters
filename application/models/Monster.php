<?php

/**
 * Created by PhpStorm.
 * User: Maxmyd
 * Date: 25.01.2018
 * Time: 20:10
 */

require_once APPPATH.'models/base/monster_base.php';

class Monster extends Monster_Base
{

    protected $table_monster_info = 'monster_base';
    protected $table_monster_ability = 'monster_ability';
    protected $table_monster_ability_link = 'monster_ability_link';
    public function __construct()
    {
        parent::__construct();
    }


    public function get_full_info($_monster_id){

        $res =  $this->db->select(
            $this->table_monster_info .'.*,'.
            $this->table_monster_ability .'.*,'.
            $this->table_monster_ability_link .'.*'

        )
            ->from($this->table_monster_info)
            ->join($this->table_monster_ability_link, $this->table_monster_info.'.id = '. $this->table_monster_ability_link .'.monster_id')
            ->join($this->table_monster_ability, $this->table_monster_ability.'.id = '. $this->table_monster_ability_link .'.monster_ability_id')
            ->where($this->table_monster_info .'.id ='. $_monster_id)
            ->get()->result_array();

        $data = array();
        foreach ($res as $info){
            if(!isset($data['info'])){
                $data['base_info'] = array(
                    'name'=>$info['name'],
                    'category'=>$info['category'],
                    'breeds'=>$info['breeds'],
                    'health'=>$info['health'],
                    'power'=>$info['power'],
                    'speed'=>$info['speed'],
                    'species'=>$info['species'],
                    'type'=>$info['type'],
                    'model'=>$info['model'],
                );
            }
            $data['skills'][$info['monster_ability_id']] = array(
                'damage'=>$info['damage'],
                'healing'=>$info['healing'],
                'healingpct'=>$info['healingpct'],
                'duration'=>$info['duration'],
                'cooldown'=>$info['cooldown'],
                'icon'=>$info['icon'],
                'name'=>$info['name'],
                'type'=>$info['type'],
            );
        }

        return $data;
    }
}