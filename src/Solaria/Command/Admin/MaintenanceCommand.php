<?php

namespace Solaria\Command\Admin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Solaria\Core;
use Solaria\Tasks\MaintenanceTasks;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class MaintenanceCommand extends Command {

    public function __construct() {
        parent::__construct("maintenance" , "Met le serveur en maintenance");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if (!$sender->hasPermission(Permissions::MAINTENANCE_ADMIN)) return $sender->sendMessage(Utils::getPrefix() . "§cVous n'avez pas la permission de mettre le serveur en maintenance.");
        if (!isset($args[0])) return $sender->sendMessage(Utils::getPrefix() . "Usage: §b/maintenance <on/off/force>§7.");
        if ($args[0] == "on") {

            Core::getInstance()->getScheduler()->scheduleRepeatingTask(new MaintenanceTasks($sender), 20);
            Core::getInstance()->getConfig()->set("Maintenance", true);
            Core::getInstance()->getConfig()->save();

        }elseif ($args[0] == "off"){

            Core::getInstance()->getConfig()->set("Maintenance", false);
            Core::getInstance()->getConfig()->save();
            Core::getInstance()->getServer()->broadcastMessage(Utils::getPrefix() . "La maintenance est terminer !");
            Utils::sendWebHook("・La maintenance du serveur est terminer, vous pouvez maintenant vous reconnectez. \n\nBon jeu à vous !", "**MAINTENANCE**", "https://discord.com/api/webhooks/926017966221447189/evJdzQjz6SsGi7-ow0-I5_MdNX0sYw7od8hiCsRh_vjVTNX0HwQg90DfuOr0HGVwyyaD");
        }elseif ($args[0] == "force") {

            Core::getInstance()->getConfig()->set("Maintenance", true);
            Core::getInstance()->getConfig()->save();
            Utils::sendWebHook("・Le serveur viens de passer en maintenance. Merci de patienter nous vous tiendrons au courrant.", "**MAINTENANCE**", "https://discord.com/api/webhooks/926017966221447189/evJdzQjz6SsGi7-ow0-I5_MdNX0sYw7od8hiCsRh_vjVTNX0HwQg90DfuOr0HGVwyyaD");
            Core::getInstance()->getServer()->broadcastMessage(Utils::getPrefix() . "Le serveur viens de passer en maintenance");
            foreach (Core::getInstance()->getServer()->getOnlinePlayers() as $player) {

                if (!$player->hasPermission(Permissions::MAINTENANCE_BYPASS)) {

                    $player->kick("§7--------------[§bMaintenance§7]§7--------------\nLe serveur viens de passer en maintenance rendez-vous sur notre discord.\n§7- Discord: §bhttps://discord.gg/VmEvsrsprV§7.\n§7--------------[§bMaintenance§7]§7--------------");


                }

            }

        }else{

            $sender->sendMessage(Utils::getPrefix() . "Usage: §b/maintenance <on/off/force>§7.");

        }

        return true;

    }

}