<?php

namespace Solaria\Command\Staff;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Solaria\Core;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class UnBanCommand extends Command{
    public function __construct(){
        parent::__construct("unban", "Permet de débannir une personne");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender->hasPermission(Permissions::BAN)) return $sender->sendMessage(Utils::getPrefix() . "Tu n'as pas la permission de unban");
        if(!isset($args[0])) return $sender->sendMessage(Utils::getPrefix() . "Usage : /unban <joueur>");
        BanCommand::$banlist->set($args[0], false);
        BanCommand::$banlist->save();
        Core::getInstance()->getServer()->broadcastMessage(Utils::getPrefix() . "§b{$args[0]} §7s'est fait débannir du serveur.");
        Utils::sendWebHook("**{$args[0]}** s'est fait débannir du serveur par **{$sender->getName()}**", "***UnBan**", "drop_your_webhook_link");
        $sender->sendMessage(Utils::getPrefix() . "Tu ne peux pas débannir quelqu'un");
        return true;
    }
}
