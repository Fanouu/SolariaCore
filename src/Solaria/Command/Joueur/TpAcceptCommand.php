<?php

namespace Solaria\Command\Joueur;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Solaria\Core;
use Solaria\Utils\Utils;

class TpAcceptCommand extends Command{
    public function __construct()
    {
        parent::__construct("tpaccept", "Permet d'accepter une demande de téléportation");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player){
            if(!isset(Core::$tpahere[$sender->getName()])){
                $sender->sendMessage(Utils::getPrefix() . "Tu n'as pas de demande de téléportation");
            }else{
                $p = Core::getInstance()->getServer()->getPlayer(Core::$tpahere[$sender->getName()]);
                if(!isset($p)) return $sender->sendMessage(Utils::getPrefix() . "Le joueur n'est pas connecté");
                if($p->getLevel()->getName() == "minevip" or $p->getLevel()->getName() == "minemvp"){
                    $p->sendMessage(Utils::getPrefix() . "Tu ne peux pas tp des joueurs en mine mvp/vip");
                }else{
                    $sender->teleport($p->getPosition());
                    $p->sendMessage(Utils::getPrefix() . "Tu as tp {$p->getName()} vers toi");
                    $sender->sendMessage("Tu as été tp {$p->getName()}");
                }
            }
            if(!isset(Core::$tpa[$sender->getName()])) return $sender->sendMessage(Utils::getPrefix() . "Tu n'as pas reçu de demande de téléportation");
        }
    }
}