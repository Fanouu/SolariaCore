<?php

namespace Solaria\Command\Admin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Solaria\Core;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class AddRankCommand extends Command {

    public function __construct() {
        parent::__construct("addrank", "Permet d'ajouter un grade");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        if (!($sender->hasPermission(Permissions::ADDRANK))) return $sender->sendMessage(Utils::getPrefix() . "§cVous n'avez pas la permission d'ajouter des grades. (§eadmin.addrank§c)");
        if (!isset($args[0])) return $sender->sendMessage(Utils::getPrefix() . "Usage: §b/addrank (nom du grade)§7.");
        if (Core::getRankAPI()->existRank($args[0])) return $sender->sendMessage(Utils::getPrefix() . "Ce grade existe déjà !");
        if (!ctype_alpha($args[0])) return $sender->sendMessage(Utils::getPrefix() . "Usage: §b/addrank (nom du grade)§7.");
        Core::getRankAPI()->addRank($args[0]);
        $sender->sendMessage(Utils::getPrefix() . "Le grade §b{$args[0]} §7a bien été ajouté à la liste des grades !");
        return true;

    }

}