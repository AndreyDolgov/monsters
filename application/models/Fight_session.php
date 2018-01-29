<?php
/**
 * Created by PhpStorm.
 * User: Maxmyd
 * Date: 23.01.2018
 * Time: 22:15
 * Tha base class of game rooms
 */


class Fight_session extends CI_Model
{

    /**
     * @var varchar $table_name - room table name
     */
    protected $table_name = 'fight_sessions';


    public function __construct()
    {
        parent::__construct();
    }


    public function check_fight_session_data($session_id){

        $res = $this->db->get_where($this->table_name,array('session_id'=>$session_id))->row_array();

        if($res == null){
            return false;
        }else{
            $res['session_data'] = json_decode($res['session_data'],true);
            return $res;
        }
    }

    public function make_fight_session_data($session_id,$user_1_id, $user_2_id,$room_type){

        $session['room_type'] = $room_type;
        $session['session_id'] = $session_id;
        $session['session_data']['users'][$user_1_id] = $this->_prepare_session_data($this->user_monster->get_fight_monsters($user_1_id));
        $session['session_data']['users'][$user_2_id] = $this->_prepare_session_data($this->user_monster->get_fight_monsters($user_2_id));
        reset($session['session_data']['users'][$user_1_id]);
        reset($session['session_data']['users'][$user_2_id]);
        $_user_1_first = key($session['session_data']['users'][$user_1_id]);
        $_user_2_first = key($session['session_data']['users'][$user_2_id]);


        $session['session_data']['statuses'] = array(
            'users'=>array($user_1_id,$user_2_id),
            'user_'. $user_1_id .'_active_monster'=>$_user_1_first,
            'user_'. $user_2_id .'_active_monster'=>$_user_2_first,
            'round'=>1,
            'round_action'=>'begin',
            'message'=>'First round'
        );

        //выглядит довольно громоздко
        //упрощенная версия определния, какой монстр ходит первым
        $session['session_data']['statuses']['first_move_user'] = $this->check_first_move($session['session_data']['users'][$user_1_id][$_user_1_first],$session['session_data']['users'][$user_1_id][$_user_1_first]);

        $this->_save_fight_session_data($session);
        return $session;
    }

    private function _prepare_session_data($user_info){

        foreach ($user_info as $id => $info){

            $_data = array();
            $_data['monster_id'] = $id;
            $_data['user_id'] = $info['user_id'];
            //на данном этапе реализация сильно упрощена - не учитываюся под типы и тому подобное
            // прирост характеристик также выбран условный
            $_data['health'] = $info['base_info']['health']*HEALTH_EXP + ($info['monster_lvl'] + LVL_MONSTER_COEFFICIENT_HEALTH);
            $_data['power'] = $info['base_info']['power'] + ($info['monster_lvl'] + LVL_MONSTER_COEFFICIENT_POWER);
            $_data['speed'] = $info['base_info']['speed'];
            foreach ( $info['skills'] as $skill_id => $skill){
                 $_data['skills'][$skill_id] = array(
                     'damage'=>    ($skill['damage'])? $skill['damage'] + ($info['monster_lvl'] + LVL_ABILITY_COEFFICIENT_DAMAGE):0,
                     'healing'=>   ($skill['healing'])? $skill['healing'] + ($info['monster_lvl'] + LVL_ABILITY_COEFFICIENT_HEALING):0,
                     'healingpct'=>($skill['healingpct'])? $skill['healingpct'] + ($info['monster_lvl'] + LVL_ABILITY_COEFFICIENT_HEALING):0,
                     'duration'=>  ($skill['duration'])? $skill['duration'] + ($info['monster_lvl'] + LVL_ABILITY_COEFFICIENT_DURATION):0,
                     'cooldown'=>  $skill['cooldown'],
                     'type'=>      $skill['type'],
                 );
            }
            $result[$id]['fight_data'] = $_data;

        }

        return $result;
    }

    //очень упрощенная версия определения, кто первый ходит
    public function check_first_move($monster_user_1,$monster_user_2){

        return ($monster_user_1['fight_data']['speed'] > $monster_user_2['fight_data']['speed'])?$monster_user_1['fight_data']['user_id']:$monster_user_2['fight_data']['user_id'];
    }

    private function _save_fight_session_data($data){

        $data['session_data'] = json_encode($data['session_data']);
        $this->db->insert($this->table_name,$data);

    }

    public function update_fight_session_data($data){

        $data['session_data'] = json_encode($data['session_data']);
        $this->db->where('session_id',$data['session_id'])->update($this->table_name,$data);

    }

    public function check_next_life_monster($current_monster,$user_monsters){

        $_monster_id = $current_monster;
        foreach ($user_monsters as $monster){
            if($monster['fight_data']['health'] > 0){
                $_monster_id = $monster['fight_data']['monster_id'];
                break;
            }
        }

        return $_monster_id;

    }
}