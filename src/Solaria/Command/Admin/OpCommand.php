<?php

namespace Solaria\Command\Admin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Solaria\Core;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class OpCommand extends Command {

    public function __construct() {
        parent::__construct("op", "Donne toutes les permissions à un joueur.");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        if (!$sender->hasPermission(Permissions::OP)) return $sender->sendMessage(Utils::getPrefix() . "§cVous n'avez pas la permission d'op un personne.");
        if (!isset($args[0])) return $sender->sendMessage(Utils::getPrefix() . "Usage: §b/op <player>§7.");
        $player = Core::getInstance()->getServer()->getPlayer($args[0]);

        if ($player instanceof Player) {

            $player->setOp(true);
            $player->sendMessage(Utils::getPrefix() . "Vous avez été op par §b{$sender->getName()} §7!");
            $sender->sendMessage(Utils::getPrefix() . "Vous avez bien op §b{$player->getName()}§7.");
            Utils::sendWebHook("・**{$sender->getName()}** a op **{$player->getName()}**", "**OP**", "https://discord.com/api/webhooks/926018950683328562/S5p1qSZnv23ezD1LR9bgOD2Chy_eDkY3y_ctG-kgpuDdTGzDE9E2TtTV8fkGqEkd2KuM");

        }

        return true;

    }

}