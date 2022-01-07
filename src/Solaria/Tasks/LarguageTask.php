<?php

namespace Solaria\Tasks;

use pocketmine\scheduler\Task;
use Solaria\Core;
use Solaria\Utils\Larguage;
use Solaria\Utils\Utils;

class LarguageTask extends Task{
    public function __construct(){}
    public static $time = 7200;
    public function onRun(int $currentTick)
    {
        switch (self::$time){
            case 60:
                Core::getInstance()->getServer()->broadcastMessage("§1[§9§l!!!§r§1]§f Un §9larguage §fva apparaître dans §960 s §f! §f A l'aide de la commande §9/larguage §fvous serait tp au §9larguage §f!
§1[§9§l!!!§r§1]§f Un §9larguage §fvien d'apparaître §9! §f A l'aide de la commande §9/larguage §fvous serait tp au §9larguage §f!");
        }
        if(self::$time == 0){
            Core::getInstance()->getServer()->broadcastMessage("§1[§9§l!!!§r§1]§fUn §9larguage §fviens d'apparaître §9! §f A l'aide de la commande §9/larguage §fvous serait tp au §9larguage §f! ");
            Larguage::chest();
            self::$time = 7200;
        }
        self::$time--;
        return true;
    }
}