<?php

namespace Solaria\Command\Joueur;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Solaria\Command\Joueur\BoutiqueCommand;
use Solaria\Core;
use Solaria\Utils\Utils;

class SendPbCommand extends Command{
    public function __construct()
    {
        parent::__construct("sendpb", "Permet de d'envoyer des pb a quelqu'un");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!BoutiqueCommand::$pb->exists($sender->getName())) BoutiqueCommand::$pb->set($sender->getName(), 0);
        if(count($args) < 2) return $sender->sendMessage(Utils::getPrefix() . "Usage : /sendpb <player> <count>");
        $p = Core::getInstance()->getServer()->getPlayer($args[0]);
        if(!isset($p)) return $sender->sendMessage(Utils::getPrefix() . "Merci de prendre un joueur connecté");
        if($p->getName() == $sender->getName()) return $sender->sendMessage(Utils::getPrefix() . "Tu ne peux pas envoyer de l'argent à toi même");
        if(!is_numeric($args[1])) return $sender->sendMessage(Utils::getPrefix() . "Merci de mettre un vrai nombre");
        if(BoutiqueCommand::$pb->get($p->getName()) - $args[1] < 0) return $sender->sendMessage(Utils::getPrefix() . "Tu n'as pas assez de pb");
        if($args[1] < 0) return $sender->sendMessage(Utils::getPrefix() . "Merci de mettre une somme au dessus de 0 pb");
        BoutiqueCommand::$pb->set($sender->getName(), BoutiqueCommand::$pb->get($sender->getName()) - $args[1]);
        BoutiqueCommand::$pb->set($p-$this->getName(), BoutiqueCommand::$pb->get($p->getName()) + $args[1]);
        $sender->sendMessage(Utils::getPrefix() . "Tu as bien donné {$args[0]} pb à {$p}");
        $p->sendMessage(Utils::getPrefix() . "Tu as reçu {$args[1]} pb de la part de {$sender->getName()}");
        BoutiqueCommand::$pb->save();
        return true;
    }
}