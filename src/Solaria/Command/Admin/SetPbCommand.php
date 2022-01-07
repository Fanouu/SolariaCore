<?php

namespace Solaria\Command\Admin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Solaria\Command\Joueur\BoutiqueCommand;
use Solaria\Core;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class SetPbCommand extends Command{
    public function __construct()
    {
        parent::__construct("setpb", "Permet de définir les pb de quelqu'un");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!BoutiqueCommand::$pb->exists($sender->getName())) BoutiqueCommand::$pb->set($sender->getName(), 0);
        if(!$sender->hasPermission(Permissions::GIVEPB)) return $sender->sendMessage("Tu n'as pas la permission de faire ceci");
        if(count($args) < 2) return $sender->sendMessage(Utils::getPrefix() . "Usage : /setpb <player> <count>");
        $p = Core::getInstance()->getServer()->getPlayer($args[0])->getName();
        if(!isset($p)) $p = $args[0];
        BoutiqueCommand::$pb->set($p, $args[1]);
        $sender->sendMessage(Utils::getPrefix() . "Tu as bien set les pb de {$p} à {$args[0]}");
        BoutiqueCommand::$pb->save();
        return true;
    }
}