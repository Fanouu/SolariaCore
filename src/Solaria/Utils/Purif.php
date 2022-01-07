<?php

namespace Solaria\Utils;

use pocketmine\Player;
use Solaria\Core;
use Solaria\Tasks\PurifTask;

class Purif{
    public static  $pl = [];
    public static $purif_anti = [];
    
    public static function onZone(Player $player) {

        $minX = min(107, 111);
        $maxX = max(107, 111);
        $minY = min(74, 76);
        $maxY = max(74, 76);
        $minZ = min(97, 101);
        $maxZ = max(97, 101);

        if($player->getX() >= $minX && $player->getX() <= $maxX
            && $player->getY() >= $minY && $player->getY() <= $maxY
            && $player->getZ() >= $minZ && $player->getZ() <= $maxZ) {
            self::activePurif($player);
            return true;

        } else return self::disablePurif($player);
    }
    
    public static function activePurif(Player $p){
        if(self::$pl[$p->getName()] == "oui"){
            return true;
        }else{
            Core::getInstance()->getScheduler()->scheduleRepeatingTask(new PurifTask($p), 20);
            self::$pl[$p->getName()] = "oui";
            if(!isset(self::$purif_anti[$p->getName()])) self::$purif_anti[$p->getName()] = 10;
        }
        return true;
    }
    public static function disablePurif(Player $p){
        self::$pl[$p->getName()] = "non";
        unset(self::$purif_anti[$p->getName()]);
    }
}