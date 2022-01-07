<?php

namespace Solaria\Command\Joueur;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Solaria\Tasks\MinageTask;

class MineInfoCommand extends Command{
    public function __construct()
    {
        parent::__construct("mineinfo", "Permet d'avoir des informations sur les mines");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $classique = MinageTask::$timeMine;
        $vip = MinageTask::$timeMineVIP;
        $sender->sendMessage("§7====================\n");
        $sender->sendMessage("§9§l» §r§fMinage Info ");
        $sender->sendMessage("§fMinage §9classique §f:§7 {$classique} seconde(s)");
        $sender->sendMessage("§fMinage §9VIP/MVP   §f:§7 {$vip} seconde(s)");
        $sender->sendMessage("§9§l» §r§fMinage Info \n");
        $sender->sendMessage("§7====================");
    }
}