<?php

namespace Solaria\Command\Joueur;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Solaria\Core;
use Solaria\Utils\Utils;

class ListCommand extends Command {

    public function __construct() {
        parent::__construct("list", "Permet de voir la list des joueurs");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        $playerNames = array_map(function(Player $player) : string{
            return $player->getName();
        }, array_filter($sender->getServer()->getOnlinePlayers(), function(Player $player) use ($sender) : bool{
            return $player->isOnline() and (!($sender instanceof Player) or $sender->canSee($player));
        }));
        sort($playerNames, SORT_STRING);
        $count = count($playerNames);
        $sender->sendMessage(Utils::getPrefix() . "Liste des joueurs connectés sur §bSolaria §7(§b{$count}§7/§b{$sender->getServer()->getMaxPlayers()}§7) :\n§7- §b" . implode("§7, §b", $playerNames));
        return true;

    }

}