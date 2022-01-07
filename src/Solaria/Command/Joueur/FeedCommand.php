<?php

namespace Solaria\Command\Joueur;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Solaria\Utils\Utils;

class FeedCommand extends Command {

    public function __construct() {
        parent::__construct("feed", "Permet de se nourrir");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        if ($sender instanceof Player) {

            if ($sender->getFood() === 20) {

                $sender->sendMessage(Utils::getPrefix() . "§cVotre nourriture est déjà au maximum.");

            }else{

                $sender->setFood(20);
                $sender->setSaturation(20);
                $sender->sendMessage(Utils::getPrefix() . "Vous avez été nourrie.");

            }

        }else{

            $sender->sendMessage(Utils::getPrefix() . "Utilsez cette command en jeu.");

        }

    }

}