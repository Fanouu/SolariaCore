<?php

namespace Solaria\Command\Staff;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Solaria\Core;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class UnMuteCommand extends Command{
    public function __construct()
    {
        parent::__construct("unmute", "Permet de unmute un joueur");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $mute = MuteCommand::$mutelist;
        if(!isset($args[0])) return $sender->sendMessage(Utils::getPrefix() . "Usage : /mute <player> [temps:min]");
        if(!$sender->hasPermission(Permissions::MUTE)) return $sender->sendMessage(Utils::getPrefix() . "Tu n'as pas la permission de unmute");
        $p = Core::getInstance()->getServer()->getPlayer($args[0]);
        $mute->set($p->getName(), false);
        $mute->save();
        $sender->sendMessage(Utils::getPrefix() . "Tu as bien umute {$p->getName()}'");
        return true;
    }
}