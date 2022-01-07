<?php

namespace Solaria\Command\Admin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Solaria\Core;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class SetupermissionCommand extends Command {

    public function __construct()
    {
        parent::__construct("setuperm", "Permet d'ajouter une permission à un joueur");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!($sender->hasPermission(Permissions::SETUPERM))) return $sender->sendMessage(Utils::getPrefix() . "§cVous n'avez pas la permission d'utiliser cette commande. (§eadmin.setuperm§c).");
        if (!isset($args[0]) or !isset($args[1])) return $sender->sendMessage(Utils::getPrefix() . "Usage: §b/setuperm (joueur) (permission)§7.");
        if (!Core::getInstance()->getServer()->getPlayer($args[0])) return $sender->sendMessage(Utils::getPrefix() . "Ce joueur n'est pas connecté !");
        $target = Core::getInstance()->getServer()->getPlayer($args[0]);
        $targetName = $target->getName();
        Core::getRankAPI()->adduPermissions($target, $args[1]);
        $sender->sendMessage(Utils::getPrefix() . "Vous avez bien ajouté la permission §b{$args[1]} §7au joueur §b{$targetName}§7 !");
        return true;
    }

}