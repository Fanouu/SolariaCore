<?php

namespace Solaria\Tasks;

use pocketmine\Player;
use pocketmine\scheduler\Task;
use Solaria\Core;
use Solaria\Utils\Utils;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\Server;
use Solaria\Command\Joueur\CosmeticCommand;

class AtoutTask extends Task{
    
    public function __construct($player, $atout = null){
        $this->player = Server::getInstance()->getPlayerExact($player);
        $this->atout = $atout;
    }
    public function onRun(int $currentTick){
        if($this->player->isConnected()){
            if($this->atout === "speed"){
                $this->player->addEffect(new EffectInstance(Effect::getEffect(Effect::SPEED), 20*10, 1));
                CosmeticCommand::$atoutPlayers[$this->player->getName()."_speed"] = $this->getTaskId();
            }
            
            if($this->atout === "jump"){
                $this->player->addEffect(new EffectInstance(Effect::getEffect(Effect::JUMP_BOOST), 20*10, 1));
                CosmeticCommand::$atoutPlayers[$this->player->getName()."_jump"] = $this->getTaskId();
            }
        }
    }
}