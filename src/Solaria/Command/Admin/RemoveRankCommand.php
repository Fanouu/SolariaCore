<?php

namespace Solaria\Command\Admin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Solaria\Core;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class RemoveRankCommand extends Command {

    public function __construct()
    {
        parent::__construct("rmrank", "Supprime un grade.");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){

        if (!($sender->hasPermission(Permissions::RMRANK))) return $sender->sendMessage(Utils::getPrefix() . "§cVous n'avez pas la permission d'utiliser cette commande. (§eadmin.removerank§c).");
        if (!isset($args[0])) return $sender->sendMessage(Utils::getPrefix() . "Usage: §b/rmrank (grade)§7.");
        if (!Core::getRankAPI()->existRank($args[0])) return $sender->sendMessage(Utils::getPrefix() . "Ce grade n'existe pas !");
        Core::getRankAPI()->rmRank($args[0]);
        $sender->sendMessage(Utils::getPrefix() . "Vous avez bien supprimé le grade §b{$args[0]}§7 !");
        return true;

    }

}