<?php

namespace Solaria\Tasks;

use pocketmine\Player;
use pocketmine\scheduler\Task;
use Solaria\Core;
use Solaria\Utils\Utils;

class TpTask extends Task{
    public $time = 30;
    public $sender;
    public $player;
    public function __construct(Player $sender, Player $player){
        $this->sender = $sender;
        $this->player = $player;
    }
    public function onRun(int $currentTick)
    {
        if($this->time == 0){
            if($this->player->isConnected()) $this->player->sendMessage(Utils::getPrefix() . "La demande à été expiré"); Core::getInstance()->getScheduler()->cancelTask($this->getTaskId());
            if($this->sender->isConnected()) $this->sender->sendMessage(Utils::getPrefix() . "Votre demande à été expiré"); Core::getInstance()->getScheduler()->cancelTask($this->getTaskId());
            unset(Core::$tpahere[$this->player->getName()]);
            unset(Core::$tpa[$this->sender->getName()]);
            Core::getInstance()->getScheduler()->cancelTask($this->getTaskId());
        }else {
            $this->time--;
        }
    }
}