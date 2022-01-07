<?php

namespace Solaria\Command\Staff;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Solaria\Core;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class TBanCommand extends Command{
    public function __construct(){
        parent::__construct("tban", "Permet de ban temporairement une personne");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player){
            if($sender->hasPermission(Permissions::BAN)){
                if(!isset($args[0])) return $sender->sendMessage(Utils::getPrefix() . "Usage : /tban <joueur> (d)");
                if(!isset($args[1])) return $sender->sendMessage(Utils::getPrefix() . "Usage : /tban <joueur> (d)");
                $p = Core::getInstance()->getServer()->getPlayer($args[0]);
                $d = $args[1];
                $temps = ($d * 3600 * 24) + time();
                if(!isset($p)){
                    BanCommand::$banlist->set($args[0], $temps);
                }else {
                    BanCommand::$banlist->set($p->getName(), $temps);
                }
                BanCommand::$banlist->save();
                Core::getInstance()->getServer()->broadcastMessage(Utils::getPrefix() . "§b{$p->getName()} §7viens de se faire bannir du serveur par §b{$sender->getName()}§7 pendant §b{$d} §7jour(s).");
                $p->kick("§7---------------[§bBannissement§7]---------------\n§7Tu t'es fait bannir du serveur temporairement \n§7- Staff: §b{$sender->getName()}\n§7- Discord: §bhttps://discord.gg/kxBnmFXAWA\n§7---------------------------------------", false);
            }else{
                $sender->sendMessage(Utils::getPrefix() . "Tu n'as pas la permission de ban quelqu'un");
            }
        }
        return true;
    }
}