<?php

namespace Solaria\Command\Admin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Solaria\Core;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class SetpermissionCommand extends Command {

    public function __construct() {
        parent::__construct("setpermission", "Permet d'ajouter une permission.");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        if (!($sender->hasPermission(Permissions::SETPERM))) return $sender->sendMessage(Utils::getPrefix() . "§cVous n'avez pas la permission d'utiliser cette commande. (§eadmin.setperm§c).");
        if (!isset($args[0]) or !isset($args[1])) return $sender->sendMessage(Utils::getPrefix() . "Usage: §b/setpermission (grade) (permission)§7.");
        if (!Core::getRankAPI()->existRank($args[0])) return $sender->sendMessage(Utils::getPrefix() . "Ce grade n'existe pas !");
        Core::getRankAPI()->addPermissions($args[0], $args[1]);
        $sender->sendMessage(Utils::getPrefix() . "Vous avez bien ajouté la permission §b{$args[1]} §7au grade §b{$args[0]}§7 !");
        return true;

    }

}