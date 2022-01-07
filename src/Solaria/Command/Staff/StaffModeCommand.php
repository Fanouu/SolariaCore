<?php

namespace Solaria\Command\Staff;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Solaria\API\StaffModeAPI;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class StaffModeCommand extends Command {

    public function __construct() {
        parent::__construct("staffmode" ,"Vous met en mode staff.");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        if (!$sender instanceof Player) return $sender->sendMessage(Utils::getPrefix() . "Utilisez cette commande en jeu.");
        if (!($sender->hasPermission(Permissions::STAFFMODE))) return $sender->sendMessage(Utils::getPrefix() . "§cVous n'avez pas la permission de faire ceci. (§estaff.staffmode§c).");
        if (StaffModeAPI::isStaffMode($sender)) {

            StaffModeAPI::removeStaffMode($sender);

        }else{

            StaffModeAPI::setStaffMode($sender);

        }

        return true;

    }

}