<?php

namespace Solaria\Listener;

use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\Listener;
use Solaria\Core;

class SpawnListener implements Listener{
    public static $Players = [];
    
    public function onMove(PlayerMoveEvent $event){
        $player = $event->getPlayer();
        $pname = $event->getPlayer()->getName();
        $toPos = $event->getTo();
        $fromPos = $event->getFrom();
        if(isset(self::$Players[$pname])){
            if($toPos->x !== $fromPos->x){
                Core::getInstance()->getScheduler()->cancelTask(self::$Players[$pname]);
                unset(self::$Players[$pname]);
                $player->sendPopup("» §9Action §l§9annulé§r§9 !");
            }
        }
    }
}