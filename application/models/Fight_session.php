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
     * @var varchar $table_name - session table name
     */
    protected $table_name = 'fight_sessions';

    public $session_id = null;
    public $session_data = null;
    public $room_type = null;
    public $status = ROOM_STATUS_NEW;

    public function __construct()
    {
        parent::__construct();
    }

    public function init_fight_session_data($session_id,$user_1_id, $user_2_id,$room_type){

        $this->check_fight_session_data($session_id);

        if($this->session_id === null){
            $this->make_fight_session_data($session_id,$user_1_id, $user_2_id,$room_type);
        }
    }

    public function init_fight($session_id){
        $this->check_fight_session_data($session_id);
    }

    private function check_fight_session_data($session_id){

        $res = $this->db->get_where($this->table_name,array('session_id'=>$session_id,'status !='=>ROOM_STATUS_CLOSED))->row();

        if($res != null){
            $this->session_data = json_decode($res->session_data);
            $this->session_id = $res->session_id;
            $this->room_type = $res->room_type;
        }
    }

    private function make_fight_session_data($session_id,$user_1_id, $user_2_id,$room_type){

        $this->room_type = $room_type;
        $this->session_id = $session_id;
        $this->session_data['users'][$user_1_id] = $this->_prepare_session_data($this->user_monster->get_fight_monsters($user_1_id));
        $this->session_data['users'][$user_2_id] = $this->_prepare_session_data($this->user_monster->get_fight_monsters($user_2_id));
        reset($this->session_data['users'][$user_1_id]);
        reset($this->session_data['users'][$user_2_id]);
        $_user_1_first = key($this->session_data['users'][$user_1_id]);
        $_user_2_first = key($this->session_data['users'][$user_2_id]);


        $this->session_data['statuses'] = array(
            'users'=>array($user_1_id,$user_2_id),
            'user_'. $user_1_id .'_active_monster'=>$_user_1_first,
            'user_'. $user_2_id .'_active_monster'=>$_user_2_first,
            'round'=>1,
            'round_action'=>'begin',
            'message'=>'First round',
            'over_time'=>[],
            'die'=>array($user_1_id=>array(),$user_2_id=>array())
        );

        //выглядит довольно громоздко
        //упрощенная версия определния, какой монстр ходит первым
        $this->session_data['statuses']['first_move_user'] = $this->check_first_move($this->session_data['users'][$user_1_id][$_user_1_first],$this->session_data['users'][$user_1_id][$_user_1_first]);

        $this->_save_fight_session_data();
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

    private function _save_fight_session_data(){

        $this->session_data = json_encode($this->session_data);

        $this->db->insert($this->table_name,$this);

    }

    public function update_fight_session_data(){

        $this->session_data = json_encode($this->session_data);
        $this->db->where('session_id',$this->session_id)->update($this->table_name,$this);

    }

    public function close_session(){
        $this->session_data = json_encode($this->session_data);
        $this->status = ROOM_STATUS_CLOSED;
        $this->db->where('session_id',$this->session_id)->update($this->table_name,$this);
    }

    private function check_next_life_monster($current_monster,$user_id){

        $_monster_id = $current_monster;
        foreach ($this->session_data->users->{$user_id} as $monster){
            if($monster->fight_data->health > 0){
                $_monster_id = $monster->fight_data->monster_id;
                break;
            }
        }

        return $_monster_id;

    }

    public function _security_method($user_id){

        if($this->session_id === null){
            error('Error. Session error. Are you cheater? ;)');
        }

        if(
            ( $this->session_data->statuses->first_move_user !=  $user_id &&  $this->session_data->statuses->round_action == 'begin') ||
            ( $this->session_data->statuses->first_move_user ==  $user_id &&  $this->session_data->statuses->round_action != 'begin')
        ){
            error('Error. Don`t you move. Are you cheater? ;)');
        }
    }

    public function monster_repose($_defence_user_id,$_defence_monster_id){

        $this->session_data->statuses->die->{$_defence_user_id}->{$_defence_monster_id} = $_defence_monster_id;
        $this->session_data->statuses->{'user_'. $_defence_user_id .'_active_monster'} = $this->check_next_life_monster($_defence_monster_id,$_defence_user_id);

    }

    public function update_over_time($data){
//        foreach ($data as $item){
//            $this->session_data->statuses->over_time[] = $item;
//        }
    }

    public function action_over_time(){

        if(count($this->session_data->statuses->over_time) == 0)
            return;

        //эксплуатация показала, что нужно будет измеить подход и все скилы сначала ассоциировать с монстром а потом уже делить на типы
        //что бы после смерти монстра можно было сразу очистить все эфекты, которые на нем весели

//        foreach ($this->session_data->statuses->over_time as $key => $action){
//
//
//            switch ($action->type){
//
//                case 'damage':
//
//                    $this->session_data->users->{$action->user_id}->{$action->monster_id}->fight_data->health -= $action->value;
//                    if($this->session_data->users->{$action->user_id}->{$action->monster_id}->fight_data->health <= 0){
//                        $this->monster_repose($action->user_id,$action->monster_id);
//                    }
//
//                    break;
//
//                case 'healing':
//                    $this->session_data->users->{$action->user_id}->{$action->monster_id}->fight_data->health += $action->value;
//                    break;
//            }
//            $this->session_data->statuses->over_time[$key]->duration--;
//
//            if($this->session_data->statuses->over_time[$key]->duration <= 0){
//                unset($this->session_data->statuses->over_time[$key]);
//            }
//
//            if(isset($this->session_data->statuses->die->{$action->user_id}->{$action->monster_id}) && isset($this->session_data->statuses->over_time[$key])){
//                unset($this->session_data->statuses->over_time[$key]);
//            }
//        }
    }

    //подсказка возможностей
    public function _users_actions(){

        $res = $this->db->get_where($this->table_name,array('session_id'=>$this->session_id))->row();

        if($res === null)
            return;

        $_session_data = json_decode($res->session_data);

        foreach ($_session_data->users as $key => $user_data){
            echo '-------'. PHP_EOL;
            echo 'user_id: '. $key . PHP_EOL;
            foreach ($user_data as $monster_id => $monster){
                echo '-------'. PHP_EOL;
                echo 'monster_id: '. $monster_id . PHP_EOL;
                echo 'health: '. $monster->fight_data->health . PHP_EOL;
                echo 'speed: '. $monster->fight_data->speed . PHP_EOL;
                foreach ($monster->fight_data->skills as $skill_id => $skill){
                    echo 'skill_id: '. $skill_id .' damage: '. $skill->damage .', healing:'. $skill->healing .', healingpct :'. $skill->healingpct .' , duration: '. $skill->duration .PHP_EOL;
                }
            }
            echo '-------'. PHP_EOL;
        }

        print_r($_session_data->statuses);

    }

    
}