<?php

namespace Solaria\Tasks;

use pocketmine\Player;
use pocketmine\scheduler\Task;
use Solaria\Command\Joueur\AtmCommand;
use Solaria\Core;

class AtmTask extends Task{
    public function __construct(){}
    public function onRun(int $currentTick)
    {
        foreach(Core::getInstance()->getServer()->getOnlinePlayers() as $p){
            if(AtmCommand::$atm->exists($p->getName())){
                AtmCommand::$atm->set($p->getName(), AtmCommand::$atm->get($p->getName()) + 1);
                $p->sendPopup("§c> §7ATM :+1 §c<");
            }
        }
    }
}