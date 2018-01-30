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

        $_fight = $this->fight_session;
        $_fight->init_fight_session_data($session_id,$user_1_id, $user_2_id,$room_type);

        echo 'Users in fight!'. PHP_EOL;

        $_fight->_users_actions();
    }

    public function action_fight($session_id, $attack_user_id, $skill_id){

        $_fight = $this->fight_session;
        $_fight->init_fight($session_id);
        $_fight->_security_method($attack_user_id);

        $_attack_user = $_fight->session_data->users->{$attack_user_id};
        $_attack_monster_id = $_fight->session_data->statuses->{'user_'. $attack_user_id .'_active_monster'};
        $_attack_monster = $_attack_user->{$_attack_monster_id};

        if(!isset($_attack_monster->fight_data->skills->{$skill_id})){
            error('Error. You monster haven`t this skill');
        }

        $_defence_user_id = ($_fight->session_data->statuses->users[0] == $attack_user_id)?$_fight->session_data->statuses->users[1]:$_fight->session_data->statuses->users[0];
        $_defence_user = $_fight->session_data->users->{$_defence_user_id};
        $_defence_monster_id = $_fight->session_data->statuses->{'user_'. $_defence_user_id .'_active_monster'};
        $_defence_monster = $_defence_user->{$_defence_monster_id};
        $scramble_result = $this->scramble->monster_fight($_attack_monster,$skill_id,$_defence_monster);
        $_fight->session_data->users->{$attack_user_id}->{$_attack_monster_id} = $scramble_result['attack_monster'];
        $_fight->session_data->users->{$_defence_user_id}->{$_defence_monster_id} = $scramble_result['defence_monster'];

        if(isset($scramble_result['over_time'])){
            $_fight->update_over_time($scramble_result['over_time']);
        }
        if($scramble_result['defence_status'] == 'die'){
            $_fight->monster_repose($_defence_user_id,$_defence_monster_id);
        }

        $_fight = $this->_round_action($_fight,$attack_user_id);

        $_fight->update_fight_session_data();

        $_fight->_users_actions();
    }

    public function action_change($session_id, $user_id, $monster_id){

        $_fight = $this->fight_session;
        $_fight->init_fight($session_id);
        $_fight->_security_method($user_id);

        if(!isset($_fight->session_data->users->{$user_id}->{$monster_id})){
            error('Error. You don`t have this monster');
        }

        if(isset($_fight->session_data->statuses->die->{$user_id}) && in_array($monster_id,$_fight->session_data->statuses->die->{$user_id})){
            error('Error. This monster already die');
        }

        $_fight->session_data->statuses->{'user_'. $user_id .'_active_monster'} = $monster_id;

        $_fight->update_fight_session_data();

        $_fight->_users_actions();
    }

    private function _round_action($fight,$action_user){

        if($fight->session_data->statuses->first_move_user == $action_user){
            $fight->session_data->statuses->round_action = 'middle';
        }else{
            $fight->session_data->statuses->round_action = 'begin';
            $fight->session_data->statuses->round++ ;
            $fight->action_over_time();
        }

        $fight = $this->_check_winner($fight);

        return $fight;
    }

    private function _check_winner($fight){

        if(count($fight->session_data->statuses->die) == 0)
            return $fight;

        $lost = array();
        $winner = array();
        foreach ($fight->session_data->statuses->die as $user_id => $user_monsters){
            if(count($user_monsters) == 3){
                $lost[] = $user_id;
            }else{
                $winner[] = $user_id;
            }
        }

        switch (count($lost)){
            case 0:
                $fight->session_data->statuses->message = 'Round '.  $fight->session_data->statuses->round;
                break;
            case 1:
                $fight->session_data->statuses->message = 'User '. $winner[0] .' winner!';
                $fight->close_session();
                $this->close_room($fight->session_id,$fight->room_type,ROOM_STATUS_CLOSED,$winner[0]);

                $this->experience->add_user_exp($winner[0]);
                break;
            case 2:

                $fight->session_data->statuses->message = 'Friendship won :D';
                $fight->close_session();
                $this->close_room($fight->session_id,$fight->room_type,ROOM_STATUS_CLOSED,0);
                break;
        }

        echo $fight->session_data->statuses->message;
        return $fight;
    }

    //вызываем, если истек срок ожидания
    //вызываем для объявления победителя
    //возможно, необходимо будет разнести функционал
    public function close_room($session_id,$room_type,$status,$winner_id){


        $_room = $this->{$this->room_type_classes[$room_type]};
        $_room->close_room($session_id,$status,$winner_id);

        echo 'Room closed!'. PHP_EOL;
    }


}