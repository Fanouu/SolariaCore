<?php

namespace Solaria\Listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use Solaria\Core;
use Solaria\Utils\Permissions;

class MaintenanceListener implements Listener {

    public function onMaintenance(PlayerJoinEvent $event) {

        $sender = $event->getPlayer();

        if (Core::getInstance()->getConfig()->get("Maintenance") === true) {

            if (!$sender->hasPermission(Permissions::MAINTENANCE_BYPASS)) {
                if($sender->getName() == "LingeJeanDus") {
                    $sender->sendMessage("cc");
                }else{
                	$sender->kick("§7--------------[§bMaintenance§7]§7--------------\nLe serveur est en maintenance rendez-vous sur notre discord.\n§7- Discord: §bhttps://discord.gg/VmEvsrsprV§7.\n§7--------------[§bMaintenance§7]§7--------------", false);
                }
            }

        }

    }

}