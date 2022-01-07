<?php

namespace Solaria\Command\Joueur;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Solaria\Command\Staff\MuteCommand;
use Solaria\Core;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class MsgCommand extends Command{
    public function __construct(){
        parent::__construct("msg", "Permet a parler à quelqu'un discrétement");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(MuteCommand::$mutelist->get($sender->getName()) == "vie") return $sender->sendMessage(Utils::getPrefix() . "Tu es mute tu ne peux pas parler en msg");
        if(MuteCommand::$mutelist->get($sender->getName()) > time()) return $sender->sendMessage(Utils::getPrefix() . "Tu es mute tu ne peux pas parler en msg");
        if(count($args) < 2) return $sender->sendMessage(Utils::getPrefix() . "Usage : /msg <player> <msg>");
        $message = [];
        $p = Core::getInstance()->getServer()->getPlayer($args[0]);
        if(!isset($p)) return $sender->sendMessage(Utils::getPrefix() . "§cCe joueur n'est pas connecté");
        for ($i = 1; $i < count($args); $i++) {
            array_push($message, $args[$i]);
        }
        $message = implode(" ", $message);
        $sender->sendMessage("§3Envoyé à §e{$p->getName()} : §7{$message}");
        $p->sendMessage("§3Reçu de §e{$sender->getName()} : §7{$message}");
        $me = $p;
        foreach (Core::getInstance()->getServer()->getOnlinePlayers() as $p){
            if($p->hasPermission(Permissions::SEEMSG)){
                $me->sendMessage("§3Envoyé de {$sender->getName()} à {$me->getName()} : §7{$message}");
            }
        }
        return true;
    }
}