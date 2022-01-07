<?php

namespace Solaria\Command\Admin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Solaria\Command\Joueur\BoutiqueCommand;
use Solaria\Core;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class AddPbCommand extends Command{
    public function __construct()
    {
        parent::__construct("addpb", "Permet de d'ajouter des pb à quelqu'un");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!BoutiqueCommand::$pb->exists($sender->getName())) BoutiqueCommand::$pb->set($sender->getName(), 0);
        if(!$sender->hasPermission(Permissions::GIVEPB)) return $sender->sendMessage("Tu n'as pas la permission de faire ceci");
        if(count($args) < 2) return $sender->sendMessage(Utils::getPrefix() . "Usage : /addpb <player> <count>");
        $p = Core::getInstance()->getServer()->getPlayer($args[0])->getName();
        if(!isset($p)) $p = $args[0];
        BoutiqueCommand::$pb->set($p, $args[1] + BoutiqueCommand::$pb->get($p));
        $sender->sendMessage(Utils::getPrefix() . "Tu as bien ajouté  à {$args[0]} pb à {$p}");
        BoutiqueCommand::$pb->save();
        return true;
    }
}