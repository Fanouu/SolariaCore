<?php

namespace Solaria\Command\Staff;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class ClearCommand extends Command {

    public function __construct() {
        parent::__construct("clear", "Permet de vider son inventaire.");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        if ($sender instanceof Player) {

            if (!($sender->hasPermission(Permissions::CLEAR))) return $sender->sendMessage(Utils::getPrefix() . "§cVous n'avez pas la permission de faire ceci. (§estaff.clear§c).");

            $sender->getInventory()->clearAll();
            $sender->getArmorInventory()->clearAll();
            $sender->sendMessage(Utils::getPrefix() . "Vous avez été clear.");

        }

    }

}