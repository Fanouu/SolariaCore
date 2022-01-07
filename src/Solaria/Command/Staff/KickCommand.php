<?php

namespace Solaria\Command\Staff;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Solaria\Core;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class KickCommand extends Command {

    public function __construct() {
        parent::__construct("kick", "Expulse un joueur du serveur.");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        if ($sender->hasPermission(Permissions::KICK)) {

            if (count($args) < 2) return $sender->sendMessage(Utils::getPrefix() . "Usage: §b/kick <player> <raison>§7.");

            $player = Core::getInstance()->getServer()->getPlayer($args[0]);

            $raison = [];
            for ($i = 1; $i < count($args); $i++) {
                array_push($raison, $args[$i]);
            }
            $raison = implode(" ", $raison);

            foreach (Core::getInstance()->getServer()->getOnlinePlayers() as $players) {

                if ($players->hasPermission("kick.staff")) {

                    $players->sendMessage(Utils::getPrefix() . "§b{$player->getName()} §7viens de se faire expulser du serveur par §b{$sender->getName()} §7pour §b{$raison}§7.");

                }else{

                    $players->sendMessage(Utils::getPrefix() . "§b{$player->getName()} §7viens de se faire expulser du serveur par §b{$sender->getName()}§7.");

                }

            }

            Utils::sendWebHook("・**{$player->getName()}** viens de se faire expulser du serveur par **{$sender->getName()}** pour **{$raison}**.", "**KICK**", "drop_your_webhook_link");
            $player->kick("§7---------------[§bExpulsion§7]---------------\n§7- Staff: §b{$sender->getName()}\n§7- Raison: §b{$raison}\n§7- Discord: §bhttps://discord.gg/kxBnmFXAWA\n§7---------------------------------------", false);

        }else{

            $sender->sendMessage(Utils::getPrefix() . "§cVous n'avez pas la permission d'expulser des joueurs.");

        }

    }

}
