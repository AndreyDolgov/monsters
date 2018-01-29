<?php
/**
 * Created by PhpStorm.
 * User: Maxmyd
 * Date: 28.01.2018
 * Time: 21:53
 */

class Scramble extends Monster_Base
{

    public function __construct()
    {
        parent::__construct();
    }

    public function monster_fight($attack_monster,$attack_skill_id,$defence_monster){

        $defence_monster['fight_data']['health'] = $defence_monster['fight_data']['health'] - $attack_monster['fight_data']['skills'][$attack_skill_id]['damage'];

        $result['defence_status'] = ($defence_monster['fight_data']['health'] > 0)? 'life':'die';

        $attack_monster['fight_data']['health'] += $attack_monster['fight_data']['skills'][$attack_skill_id]['healing'];

        if($attack_monster['fight_data']['skills'][$attack_skill_id]['duration']){
            $result['over_time'][] = array(
                'type'=>'damage',
                'monster_id'=>$defence_monster['fight_data']['monster_id'],
                'user_id'=>$defence_monster['fight_data']['user_id'],
                'value'=>$attack_monster['fight_data']['skills'][$attack_skill_id]['damage'],
                'duration'=>$attack_monster['fight_data']['skills'][$attack_skill_id]['duration']
            );

            $result['over_time'][] = array(
                'type'=>'healing',
                'monster_id'=>$attack_monster['fight_data']['monster_id'],
                'user_id'=>$defence_monster['fight_data']['user_id'],
                'value'=>$attack_monster['fight_data']['skills'][$attack_skill_id]['healing'],
                'duration'=>$attack_monster['fight_data']['skills'][$attack_skill_id]['duration']
            );
        }

        $result['defence_monster'] = $defence_monster;
        $result['attack_monster'] = $attack_monster;

        return $result;
    }

}