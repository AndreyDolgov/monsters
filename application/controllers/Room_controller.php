<?php

/**
 * Created by PhpStorm.
 * User: Maxmyd
 * Date: 25.01.2018
 * Time: 19:56
 */
class Room_controller extends CI_Controller
{

    private $room_type_classes = array(
        'classic'=>'fight_room_classic'
    );

    // создаем комнату в ответ на согласие двух пользователей на поединок
    //авторизации нет. предполагаем, что они уже авторизировались
    public function make_room($room_type, $user_1_id, $user_2_id){


        if($user_1_id == $user_2_id){
            error('Error! Wrong users have been different');
        }

        if(!isset($this->room_type_classes[$room_type])){
            error('Incorrect room type');
        }
        $_room = $this->{$this->room_type_classes[$room_type]};

        $_session_id = $_room->check_room_exist($user_1_id,$user_2_id);

        if($_session_id === false){
            $_session_id = $_room->make_room($user_1_id,$user_2_id);
        }

        echo 'Fight room created '. $_session_id . PHP_EOL;


        $this->make_fight_session($_session_id,$user_1_id, $user_2_id,$room_type);
    }

    public function make_fight_session($session_id,$user_1_id, $user_2_id,$room_type){

        $room = $this->fight_session->check_fight_session_data($session_id);

        if($room === false){
            $room = $this->fight_session->make_fight_session_data($session_id,$user_1_id, $user_2_id,$room_type);
        }

        echo 'Users in fight!'. PHP_EOL;

        $this->_users_actions($room['session_data']);
    }

    public function action_fight($session_id, $attack_user_id, $skill_id){

        $room = $this->fight_session->check_fight_session_data($session_id);
        $this->_security_method($room, $attack_user_id);

        $_attack_user = $room['session_data']['users'][$attack_user_id];
        $_attack_monster_id = $room['session_data']['statuses']['user_'. $attack_user_id .'_active_monster'];
        $_attack_monster = $_attack_user[$_attack_monster_id];

        if(!isset($_attack_monster['fight_data']['skills'][$skill_id])){
            error('Error. You monster haven`t this skill');
        }

        $_defence_user_id = ($room['session_data']['statuses']['users'][0] == $attack_user_id)?$room['session_data']['statuses']['users'][1]:$room['session_data']['statuses']['users'][0];
        $_defence_user = $room['session_data']['users'][$_defence_user_id];
        $_defence_monster_id = $room['session_data']['statuses']['user_'. $_defence_user_id .'_active_monster'];
        $_defence_monster = $_defence_user[$_defence_monster_id];
        $scramble_result = $this->scramble->monster_fight($_attack_monster,$skill_id,$_defence_monster);
        $room['session_data']['users'][$attack_user_id][$_attack_monster_id] = $scramble_result['attack_monster'];
        $room['session_data']['users'][$_defence_user_id][$_defence_monster_id] = $scramble_result['defence_monster'];

        if(isset($scramble_result['over_time'])){
            $room['session_data']['statuses']['over_time'] = (isset($room['session_data']['statuses']['over_time']))? array_merge($room['session_data']['statuses']['over_time'],$scramble_result['over_time']):$scramble_result['over_time'];
        }
        if($scramble_result['defence_status'] == 'die'){
            $room = $this->_monster_die($room,$_defence_user_id,$_defence_monster_id);
        }

        $room = $this->_round_action($room,$attack_user_id);

        $this->fight_session->update_fight_session_data($room);
        $this->_users_actions($room['session_data']);
    }

    public function action_change($session_id, $user_id, $monster_id){

        $room = $this->fight_session->check_fight_session_data($session_id);
        $this->_security_method($room, $user_id);

        if(!isset($room['session_data']['users'][$user_id][$monster_id])){
            error('Error. You don`t have this monster');
        }

        if(isset($room['session_data']['statuses']['die'][$monster_id]) && in_array($monster_id,$room['session_data']['statuses']['die'][$monster_id])){
            error('Error. This monster already die');
        }

        $room['session_data']['statuses']['user_'. $user_id .'_active_monster'] = $monster_id;
        $this->fight_session->update_fight_session_data($room);

        $this->_users_actions($room['session_data']);
    }

    private function _round_action($room,$action_user){

        if($room['session_data']['statuses']['first_move_user'] == $action_user){
            $room['session_data']['statuses']['round_action'] = 'middle';
        }else{
            $room['session_data']['statuses']['round_action'] = 'begin';
            $room['session_data']['statuses']['round']++ ;
            $room = $this->_over_time_action($room);
        }

        $room = $this->_check_winner($room);

        return $room;
    }

    private function _check_winner($room){

        if(!isset($room['session_data']['statuses']['die']))
            return $room;

        $lost = array();
        $winner = array();
        foreach ($room['session_data']['statuses']['die'] as $user_id => $user_monsters){
            if(count($user_monsters) == 3){
                $lost[] = $user_id;
            }else{
                $winner[] = $user_id;
            }
        }

        switch (count($lost)){
            case 0:
                $room['session_data']['statuses']['message'] = 'Round '.  $room['session_data']['statuses']['round'];
                break;
            case 1:
                $room['session_data']['statuses']['message'] = 'User '. $winner[0] .' winner!';
                $this->close_room($room['session_id'],ROOM_STATUS_CLOSED,$winner[0]);
                break;
            case 2:
                $room['session_data']['statuses']['message'] = 'Friendship won :D';
                $this->close_room($room['session_id'],ROOM_STATUS_CLOSED,0);
                break;
        }

        return $room;
    }

    private function _over_time_action($room){

        if(!isset($room['session_data']['statuses']['over_time']))
            return $room;

        foreach ($room['session_data']['statuses']['over_time'] as $action){

            switch ($action['type']){

                case 'damage':

                    $room['session_data'][$action['user_id']][$action['monster_id']]['fight_data']['health'] -= $action['value'];
                    if($room['session_data'][$action['user_id']][$action['monster_id']]['fight_data']['health'] <= 0){
                        $room = $this->_monster_die($room,$action['user_id'],$action['monster_id']);
                    }

                    break;


                case 'healing':
                    break;
            }
        }
        return $room;
    }

    private function _monster_die($room,$_defence_user_id,$_defence_monster_id){

        $room['session_data']['statuses']['die'][$_defence_user_id][] = $_defence_monster_id;
        $room['session_data']['statuses']['user_'. $_defence_user_id .'_active_monster'] = $this->fight_session->check_next_life_monster($_defence_monster_id,$room['session_data']['users'][$_defence_user_id]);

        return $room;
    }

    private function _security_method($room, $user_id){

        if($room === false){
            error('Error. Session error. Are you cheater? ;)');
        }

        if(
            ( $room['session_data']['statuses']['first_move_user'] !=  $user_id &&  $room['session_data']['statuses']['round_action'] == 'begin') ||
            ( $room['session_data']['statuses']['first_move_user'] ==  $user_id &&  $room['session_data']['statuses']['round_action'] != 'begin')
        ){
            error('Error. Don`t you move. Are you cheater? ;)');
        }


    }

    //вызываем, если истек срок ожидания
    //вызываем для объявления победителя
    //возможно, необходимо будет разнести функционал
    public function close_room($session_id,$status,$winner_id){
        $room = $this->fight_session->check_fight_session_data($session_id);

        if($room === false){
            error('Error. Session error. Are you cheater? ;)');
        }

        $_room = $this->{$this->room_type_classes[$room['room_type']]};
        $_room->close_room($session_id,$status,$winner_id);
    }


    //подсказка возможностей
    private function _users_actions($session_data){
        foreach ($session_data['users'] as $key => $user_data){
            echo '-------'. PHP_EOL;
            echo 'user_id: '. $key . PHP_EOL;
            foreach ($user_data as $monster_id => $monster){
                echo '-------'. PHP_EOL;
                echo 'monster_id: '. $monster_id . PHP_EOL;
                echo 'health: '. $monster['fight_data']['health'] . PHP_EOL;
                echo 'speed: '. $monster['fight_data']['speed'] . PHP_EOL;
                foreach ($monster['fight_data']['skills'] as $skill_id => $skill){
                    echo 'skill_id: '. $skill_id .' damage: '. $skill['damage'] .', healing:'. $skill['healing'] .', healingpct :'. $skill['healingpct'] .' , duration: '. $skill['duration'] .PHP_EOL;
                }
            }
            echo '-------'. PHP_EOL;
        }
//        $_str ='';
//        foreach ($session_data['statuses'] as $key => $val){
//            $_str .= $key .': '. $val .', ';
//        }
//        echo $_str;
        print_r($session_data['statuses']);

    }

}