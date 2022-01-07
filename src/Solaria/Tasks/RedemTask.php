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
            Utils::sendWebHook("・**{$sender->getName()}** viens de redem le serveur.", "**REDEM**", "https://discord.com/api/webhooks/926017966221447189/evJdzQjz6SsGi7-ow0-I5_MdNX0sYw7od8hiCsRh_vjVTNX0HwQg90DfuOr0HGVwyyaD");
            Core::getInstance()->getScheduler()->cancelTask($this->getTaskId());

        }else{

            Core::getInstance()->getServer()->broadcastMessage(Utils::getPrefix() . "Le serveur va redémarré dans §b" . $this->time . "§7!");

        }

        $this->time--;

    }

}