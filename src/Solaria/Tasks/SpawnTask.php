<?php

namespace Solaria\Tasks;

use pocketmine\Player;
use pocketmine\scheduler\Task;
use Solaria\Core;
use Solaria\Utils\Utils;
use Solaria\Listener\SpawnListener;

class SpawnTask extends Task{
    
    public static $time = [];
    public function __construct(Player $player){
        $this->player = $player;
    }
    public function onRun(int $currentTick){
        if(self::$time[$this->player->getName()] == 0){
            if($this->player->isConnected()){
                unset(SpawnListener::$Players[$this->player->getName()]);
                $this->player->teleport($this->player->getServer()->getLevelByName("kitmap")->getSafeSpawn());
                Core::getInstance()->getScheduler()->cancelTask($this->getTaskId());
            }
        }else {
            self::$time[$this->player->getName()]--;
        }
        if(!isset(SpawnListener::$Players[$this->player->getName()])){
            SpawnListener::$Players[$this->player->getName()] = $this->getTaskId();
        }
        $this->player->sendPopup("» §9Téléportation dans §l§f" . self::$time[$this->player->getName()] . " seconde(s) §r§9ne bouger plus !");
    }
}