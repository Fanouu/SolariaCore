<?php

namespace Solaria\Command\Joueur;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\Player;
use Solaria\Core;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;
use pocketmine\level\Position;

class MinageCommand extends Command{
    public function __construct()
    {
        parent::__construct("minage", "Permet de se téléporté au minage");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player){
            $sender->teleport(new Position(267, 79, 290, $sender->getServer()->getLevelByName("Minage")));
            $sender->sendMessage(Utils::getPrefix() . "Tu as bien été téléporté à la mine");
        }
        return true;
    }
}