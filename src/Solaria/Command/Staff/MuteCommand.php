<?php

namespace Solaria\Command\Staff;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\Config;
use Solaria\Core;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class MuteCommand extends Command{
    /** @var Config */
    public static $mutelist;
    public function __construct()
    {
        parent::__construct("mute", "Permet de mute quelqu'un");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $mute = self::$mutelist;
        if (!$sender->hasPermission(Permissions::MUTE)) return $sender->sendMessage(Utils::getPrefix() . "Tu n'as pas la permission de faire ceci");
        if (!isset($args[0])) return $sender->sendMessage(Utils::getPrefix() . "Usage : /mute <player> [temps:min]");
        $p = Core::getInstance()->getServer()->getPlayer($args[0]);
        if(!isset($p)) return $sender->sendMessage(Utils::getPrefix() . "Ce joueur n'est pas connecté");
        if($mute->get($p->getName()) > time()) return $sender->sendMessage(Utils::getPrefix() . "Ce joueur est déjà mute");
        if (!isset($args[1])) {
            $duree = true;
            Core::getInstance()->getServer()->broadcastMessage(Utils::getPrefix() . "§b{$p->getName()} §7à été mute par §b{$sender->getName()} §7à vie");
            $mute->set($p->getName(), "vie");
            Utils::sendWebHook("**{$p->getName()}** à été mute à **vie** par **{$sender->getName()}**", "**Mute à vie**", "https://discord.com/api/webhooks/926024060859744326/FDuN14oRZnIzaX0c2ffdaZ3NJLR_m8ngh9PkOY2qsX8ad8uCqhCIgvCAzfKOFfPsIEjF");
        } else {
            $duree = ($args[1] * 60);
            $ech = ($duree + time());
            Core::getInstance()->getServer()->broadcastMessage(Utils::getPrefix() . "§b{$p->getName()} §7à été mute par §b{$sender->getName()} §7pendant §b{$args[1]} §7minutes");
            $mute->set($p->getName(), $ech);
            Utils::sendWebHook("**{$p->getName()}** à été mute par **{$sender->getName()}** pendant **{$args[1]} minutes**", "**Mute**", "https://discord.com/api/webhooks/926024060859744326/FDuN14oRZnIzaX0c2ffdaZ3NJLR_m8ngh9PkOY2qsX8ad8uCqhCIgvCAzfKOFfPsIEjF");
        }
        $mute->save();
    }
}