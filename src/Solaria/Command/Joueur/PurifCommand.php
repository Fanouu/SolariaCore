<?php

namespace Solaria\Command\Joueur;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\Player;
use Solaria\Core;
use pocketmine\level\Position;
use Solaria\Utils\Utils;

class PurifCommand extends Command{
    public function __construct()
    {
        parent::__construct("purif", "Permet de se téléporté au purif");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player){
            $x = 90;
            $y = 74;
            $z = 80;
            $level = $sender->getServer()->getLevelByName("kitmap");
            $sender->teleport(new Position($x, $y, $z, $level));
            $sender->sendMessage(Utils::getPrefix() . "Tu as bien été tp au purif");
        }
    }
}