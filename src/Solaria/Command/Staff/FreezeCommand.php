<?php

namespace Solaria\Command\Staff;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\Config;
use Solaria\Core;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class FreezeCommand extends Command{
    /** @var Config */
    public static $freeze;
    public function __construct(){
        parent::__construct("freeze", "Permet d'immobiliser un joueur");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player){
            if($sender->hasPermission(Permissions::FREEZE)){
                if(!isset($args[0])) return $sender->sendMessage(Utils::getPrefix() . "Usage : /freeze <player>");
                $f = self::$freeze;
                $p = Core::getInstance()->getServer()->getPlayer($args[0]);
                if($f->get($p->getName()) == true){
                    $f->set($p->getName(), false);
                    $f->save();
                    $p->setImmobile(false);
                    Core::getInstance()->getServer()->broadcastMessage(Utils::getPrefix() . "§b{$p->getName()} §7a été unfreeze par §b{$sender->getName()}");
                    Utils::sendWebHook("**{$p->getName()}** à été unfreeze par **{$sender->getName()}", "**Freeze**", "https://discord.com/api/webhooks/926024060859744326/FDuN14oRZnIzaX0c2ffdaZ3NJLR_m8ngh9PkOY2qsX8ad8uCqhCIgvCAzfKOFfPsIEjF");
                }else{
                    $f->set($p->getName(), true);
                    $f->save();
                    $p->setImmobile(true);
                    $p->teleport(Core::getInstance()->getServer()->getDefaultLevel()->getSafeSpawn());
                    $p->addTitle("§aTu as étais freeze par un modérateur");
                    $p->addSubTitle("§6Viens vocal sur notre discord");
                    Core::getInstance()->getServer()->broadcastMessage(Utils::getPrefix() . "§b{$p->getName()} §7a été freeze par §b{$sender->getName()}");
                    Utils::sendWebHook("**{$p->getName()}** à été freeze par **{$sender->getName()}**", "**Freeze**", "https://discord.com/api/webhooks/926024060859744326/FDuN14oRZnIzaX0c2ffdaZ3NJLR_m8ngh9PkOY2qsX8ad8uCqhCIgvCAzfKOFfPsIEjF");
                }
            }else{
                $sender->sendMessage(Utils::getPrefix() . "Tu n'as pas la permissionde freeze un autre joueur");
            }
        }
        return true;
    }
}