<?php

namespace Solaria\Command\Admin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Solaria\Core;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class ListpermissionCommande extends Command {

    public function __construct() {
        parent::__construct("listperm", "Permet de voir la liste des permissions d'un grade.");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!($sender->hasPermission(Permissions::LISTPERM))) return $sender->sendMessage(Utils::getPrefix() . "§cVous n'avez pas la permission d'utiliser cette commande. (§eadmin.listperm§c).");
        if (!isset($args[0])) return $sender->sendMessage(Utils::getPrefix() . "Usage: §b/listperm (grade)§7.");
        if (!Core::getRankAPI()->existRank($args[0])) return $sender->sendMessage(Utils::getPrefix() . "Ce grade n'existe pas !");

        if(Core::getRankAPI()->getAllPerms($args[0]) == array()){
            $permFormat = "§cAucune";
        } else {
            $permFormat = implode("§b, ", Core::getRankAPI()->getAllPerms($args[0]));
        }
        $sender->sendMessage(Utils::getPrefix() . "Voici la liste des permissions du grade §b{$args[0]}§7 : §b{$permFormat}");
        return true;
    }

}