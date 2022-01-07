<?php

namespace Solaria\Command\Admin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Solaria\Core;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class RankCommand extends Command {

    public function __construct() {
        parent::__construct("rank", "Permet de montrer la liste des grades.");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if (!($sender->hasPermission(Permissions::RANKS))) return $sender->sendMessage(Utils::getPrefix() . "§cVous n'avez pas la permission d'utiliser cette commande. (§eadmin.rank§c).");
        $ranks = Core::getRankAPI()->getAllRanks();
        $rankFormat = "§b";
        foreach ($ranks as $rank => $format) {
            $rankFormat .= "§b{$rank}";
            $rankFormat .= "§b, ";
        }
        $sender->sendMessage(Utils::getPrefix() . "Voici la liste des grades : {$rankFormat}");
        return true;
    }

}