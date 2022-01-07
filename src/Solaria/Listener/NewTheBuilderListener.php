<?php

namespace Solaria\Listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use Solaria\Core;

class NewTheBuilderListener implements Listener {

    public function onNewJoin(PlayerJoinEvent $event) {

        $sender = $event->getPlayer();

        if (Core::getInstance()->getServer()->getPlayerExact("NewTheBuilder")) {

            Core::getInstance()->getServer()->broadcastMessage("§7[§a+§7] §6Ancien-Dev §7NewTheBuilder");

        }

    }

}