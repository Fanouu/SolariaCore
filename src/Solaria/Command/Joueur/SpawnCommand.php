<?php

namespace Solaria\Command\Joueur;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Solaria\Core;
use Solaria\Tasks\SpawnTask;
use Solaria\Utils\Utils;

class SpawnCommand extends Command {

    public function __construct() {
        parent::__construct("spawn", "Permet de se téléporter au spawn.", "", ["hub"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        if ($sender instanceof Player) {
            $sender->teleport(Core::getInstance()->getServer()->getLevelByName("kitmap")->getSafeSpawn());
        }else{

            $sender->sendMessage(Utils::getPrefix() . "Utilisez cette command en jeu.");

        }

    }

}