<?php

namespace Solaria\Command\Joueur;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Solaria\Core;

class StaffListCommand extends Command{
    public function __construct(){
        parent::__construct("stafflist", "Permet de voir la liste du staff");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        $staff = [];
        foreach (Core::getInstance()->getServer()->getOnlinePlayers() as $p) {
            if($p->hasPermission("guide")){
                $n = Core::getRankAPI()->getRankColored($p) . $p->getName();
                $staff = explode(", ", $n);
            }
        }
        $sender->sendMessage("§f===== ] §1Liste du staff connecté §f[ =====\n§f - {$staff}\n§f===== ] §1Liste du staff connecté §f[ =====");
    }
}