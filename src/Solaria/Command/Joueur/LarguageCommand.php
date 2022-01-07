<?php

namespace Solaria\Command\Joueur;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\math\Vector3;
use pocketmine\Player;
use Solaria\Core;
use Solaria\Tasks\LarguageTask;
use Solaria\Utils\Larguage;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class LarguageCommand extends Command{
    public function __construct(){
        parent::__construct("larguage", "Permet d'accéder au larguage");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender instanceof Player ){
            if(!isset($args[0])){
                $sender->sendMessage("Tu ne peux pas faire ceci, si tu veux lancer un larguage : /larguage force");
            }else{
                Core::getInstance()->getServer()->broadcastMessage(Utils::getPrefix() . "§6§lUn larguage viens de commencer au /larguage");
                Larguage::chest();
            }
        }else{
            if(!isset($args[0])){
                $sender->teleport(new Vector3(171, 51, -146));
                $sender->sendMessage(Utils::getPrefix() . "Tu as bien été tp au larguage");
            }else{
                if($args[0] == "force"){
                    if(!$sender->hasPermission(Permissions::LARGUAGEFORCE)) return $sender->sendMessage(Utils::getPrefix() . "Tu n'as pas la permission de faire ceci");
                    Core::getInstance()->getServer()->broadcastMessage(Utils::getPrefix() . "§6§lUn larguage viens de commencer au /larguage");
                    Larguage::chest();
                }
                if($args[0] == "info"){
                    $sender->sendMessage("§f===== ] §6Larguage §f[ =====");
                    $s = LarguageTask::$time;
                    $sender->sendMessage("§f > Larguage dans {$s} seconde(s)");
                }
            }
        }
        return true;
    }
}