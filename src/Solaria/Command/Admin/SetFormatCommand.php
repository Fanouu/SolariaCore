<?php

namespace Solaria\Command\Admin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Solaria\Core;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class SetFormatCommand extends Command {

    public function __construct() {
        parent::__construct("setformat", "Permet d'ajouter un format à un grade.");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        if (!($sender->hasPermission(Permissions::SETFORMAT))) return $sender->sendMessage(Utils::getPrefix() . "§cVous n'avez pas la permission d'utiliser cette commande. (§eadmin.setformat§c).");
        if (!isset($args[0]) or !isset($args[1])) return $sender->sendMessage(Utils::getPrefix() . "Usage: §b/setformat (grade) (format)");
        if (!Core::getRankAPI()->existRank($args[0])) return $sender->sendMessage(Utils::getPrefix() . "Ce grade n'existe pas !");
        $rank = $args[0];
        $format = "";
        for ($i = 1; $i < count($args); $i++) {
            $format .= $args[$i];
            $format .= " ";
        }
        Core::getRankAPI()->setFormat($rank, $format);
        $sender->sendMessage(Utils::getPrefix() . "Vous avez bien mis à jour le format du grade §b{$rank} §7!");
        return true;

    }

}