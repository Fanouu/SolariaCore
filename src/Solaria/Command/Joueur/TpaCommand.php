<?php

namespace Solaria\Command\Joueur;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Solaria\Command\Tasks\TpTask;
use Solaria\Core;
use Solaria\Utils\Utils;

class TpaCommand extends Command{
    public function __construct()
    {
        parent::__construct("tpa", "Permet de se téléporter vers quelqu'un");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player){
            if(!isset($args[0])) return $sender->sendMessage(Utils::getPrefix() . "Usage : /tpahere <player>");
            $p = Core::getInstance()->getServer()->getPlayer($args[0]);
            if(!isset($p)) return $sender->sendMessage(Utils::getPrefix() . "Le joueur n'est pas connecté");
            $sender->sendMessage("§1[§9Solaria§1] §fVotre demande de téléportation a bien été envoyée à §9{$p->getName()} §f! ");
            $p->sendMessage("§1[§9Solaria§1] §fTu as reçu une demande pour que §9{$p->getName()} §fse téléporte à vous !");
            Core::$tpahere[$p->getName()] = $sender->getName();
            Core::getInstance()->getScheduler()->scheduleRepeatingTask(new TpTask($sender, $p), 20);
        }
    }
}