<?php

namespace Solaria\Command\Admin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Solaria\Core;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class SetRankCommand extends Command {

    public function __construct() {
        parent::__construct("setrank", "Permet de donner un grade à un joueur.");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        if (!($sender->hasPermission(Permissions::SETRANK))) return $sender->sendMessage(Utils::getPrefix() . "§cVous n'avez pas la permission d'utiliser cette commande. (§eadmin.setrank§c)");
        if (!isset($args[0]) or !isset($args[1])) return $sender->sendMessage(Utils::getPrefix() . "Usage: §b/setrank (pseudo) (grade) §7.");
        if (Core::getInstance()->getServer()->getPlayer($args[0])){
            $target = Core::getInstance()->getServer()->getPlayer($args[0]);
            $targetName = $target->getName();
        } else {
            $targetName = $args[0];
        }
        if (!Core::getRankAPI()->existRank($args[1])) return $sender->sendMessage(Utils::getPrefix() . "Ce grade n'existe pas !");
        $sender->sendMessage(Utils::getPrefix() . "Le joueur §b{$targetName} §7a reçu son grade avec succès !");
        Utils::sendWebHook("・**{$targetName}** a reçu le grade **{$args[1]}** par **{$sender->getName()}**", "**RANK**", "drop_your_webhook_link");
        if(isset($target)){
            Core::getRankAPI()->setRank($target, $args[1]);
        } else {
            Core::getRankAPI()->setRank($targetName, $args[1]);
        }
        $achats = ["VIP", "VIP+", "Hero", "Champion"];
        if (in_array($args[1], $achats)) return Core::getInstance()->getServer()->broadcastMessage(Utils::getPrefix() . "§b{$targetName} §7a acheté le grade §b{$args[1]} §7!");
        return Core::getInstance()->getServer()->broadcastMessage(Utils::getPrefix() . "§b{$targetName} §7a reçu le grade §b{$args[1]} §7!");
    }

}
