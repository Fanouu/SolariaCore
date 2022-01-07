<?php

namespace Solaria\Command\Grade;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\Player;
use Solaria\Core;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;
use pocketmine\level\Position;

class MineVipCommand extends Command{
    public function __construct()
    {
        parent::__construct("minevip", "Permet de se téléporté à la mine vip");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player){
            if(!$sender->hasPermission(Permissions::MINEVIP)) return $sender->sendMessage(Utils::getPrefix() . "Tu n'as pas la permission de faire ceci");
            $sender->teleport(new Position(388, 79, 269, $sender->getServer()->getLevelByName("Minage")));
            $sender->sendMessage(Utils::getPrefix() . "Tu as bien été téléporté à la mine");
        }
        return true;
    }
}