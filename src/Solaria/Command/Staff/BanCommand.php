<?php

namespace Solaria\Command\Staff;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\Config;
use Solaria\Core;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class BanCommand extends Command {
    /** @var Config */
    public static $banlist;

    public function __construct() {
        parent::__construct("ban", "Permet de ban un joueur.");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        $config = self::$banlist;

        if ($sender->hasPermission(Permissions::BAN)) {

            if (count($args) < 2) return $sender->sendMessage(Utils::getPrefix() . "Usage: §b/ban <player> [temp]§7.");

            $player = Core::getInstance()->getServer()->getPlayer($args[0]);

            $raison = [];
            for ($i = 1; $i < count($args); $i++) {
                array_push($raison, $args[$i]);
            }
            $raison = implode(" ", $raison);

            if(!isset($player)){
                $name = $args[0];
            }else{
                $name = $player->getName();
            }
            foreach (Core::getInstance()->getServer()->getOnlinePlayers() as $players) {
                if ($players->hasPermission("ban.staff")) {

                    $players->sendMessage(Utils::getPrefix() . "§b{$name} §7viens de se faire bannir du serveur par §b{$sender->getName()} §7pour §b{$raison}§7.");

                }else{

                    $players->sendMessage(Utils::getPrefix() . "§b{$name} §7viens de se faire bannir du serveur par §b{$sender->getName()}§7.");

                }

            }
            if(isset($player)) {
                $player->kick("§7---------------[§bBannissement§7]---------------\n§7- Staff: §b{$sender->getName()}\n§7- Raison: §b{$raison}\n§7- Discord: §bhttps://discord.gg/kxBnmFXAWA\n§7---------------------------------------", false);
            }
            $config->set($name, "vie");
            Utils::sendWebHook("・**{$name}** viens de se faire bannir du serveur par **{$sender->getName()}** pour **{$raison}**.", "**BAN**", "drop_your_webhook_link");
            $config->save();

        }else{

            $sender->sendMessage(Utils::getPrefix() . "§cVous n'avez pas la permission de bannir des joueurs.");

        }

    }

}
