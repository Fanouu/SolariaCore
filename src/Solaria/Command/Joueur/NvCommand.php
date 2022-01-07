<?php

namespace Solaria\Command\Joueur;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\Player;
use Solaria\Core;

class NvCommand extends Command{
    public function __construct()
    {
        parent::__construct("nv", "Permet de voir clair");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player){
            Core::getInstance()->getServer()->dispatchCommand(new ConsoleCommandSender(), "effect \"{$sender->getName()}\" night_vision 3600");
        }
    }
}