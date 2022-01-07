<?php

namespace Solaria\Tasks;

use pocketmine\scheduler\Task;
use Solaria\Core;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class MaintenanceTasks extends Task {

    public $player;
    private $time = 5;

    public function __construct($sender) {

        $this->player = $sender;

    }

    public function onRun(int $currentTick) {

        if ($this->time === 0) {
            Utils::sendWebHook("・Le serveur viens de passer en maintenance. Merci de patienter nous vous tiendrons au courrant.", "**MAINTENANCE**", "drop_your_webhook_link");

            foreach (Core::getInstance()->getServer()->getOnlinePlayers() as $player) {

                if (!$player->hasPermission(Permissions::MAINTENANCE_BYPASS)) {

                    $player->kick("§7--------------[§bMaintenance§7]§7--------------\nLe serveur viens de passer en maintenance rendez-vous sur notre discord.\n§7- Discord: §bhttps://discord.gg/VmEvsrsprV§7.\n§7--------------[§bMaintenance§7]§7--------------", false);

                }
                Core::getInstance()->getScheduler()->cancelTask($this->getTaskId());

                Core::getInstance()->getServer()->broadcastMessage(Utils::getPrefix() . "Le serveur viens de passer en maintenance");

            }

        }else{

            Core::getInstance()->getServer()->broadcastMessage(Utils::getPrefix() . "Le serveur va passé en maintenance dans §b{$this->time} secondes §7!");

        }

        $this->time--;

    }

}
