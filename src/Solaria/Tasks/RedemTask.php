<?php

namespace Solaria\Tasks;

use pocketmine\Player;
use pocketmine\scheduler\Task;
use Solaria\Core;
use Solaria\Utils\Utils;

class RedemTask extends Task {

    private $time = 5;
    public $player;

    public function __construct($sender) {
        $this->player = $sender;

    }

    public function onRun(int $currentTick) {

        $sender = $this->player;

        if ($this->time === 0) {

            Core::getInstance()->getServer()->shutdown();
            Utils::sendWebHook("・**{$sender->getName()}** viens de redem le serveur.", "**REDEM**", "drop_your_webhook_link");
            Core::getInstance()->getScheduler()->cancelTask($this->getTaskId());

        }else{

            Core::getInstance()->getServer()->broadcastMessage(Utils::getPrefix() . "Le serveur va redémarré dans §b" . $this->time . "§7!");

        }

        $this->time--;

    }

}
