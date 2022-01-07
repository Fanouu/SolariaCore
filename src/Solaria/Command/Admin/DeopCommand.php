<?php

namespace Solaria\Command\Admin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Solaria\Core;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class DeopCommand extends Command {

    public function __construct() {
        parent::__construct("deop", "Retire toutes les permissions à un joueur.");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        if (!$sender->hasPermission(Permissions::OP)) return $sender->sendMessage(Utils::getPrefix() . "§cVous n'avez pas la permission deop un personne.");
        if (!isset($args[0])) return $sender->sendMessage(Utils::getPrefix() . "Usage: §b/deop <player>§7.");
        $player = Core::getInstance()->getServer()->getPlayer($args[0]);

        if ($player instanceof Player) {

            $player->setOp(false);
            $player->sendMessage(Utils::getPrefix() . "Vous avez été deop par §b{$sender->getName()} §7!");
            $sender->sendMessage(Utils::getPrefix() . "Vous avez bien deop §b{$player->getName()}§7.");
            Utils::sendWebHook("・**{$sender->getName()}** a deop **{$player->getName()}**", "**DEOP**", "drop_your_webhook_link");

        }

        return true;

    }

}
