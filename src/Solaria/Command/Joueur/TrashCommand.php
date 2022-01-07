<?php

namespace Solaria\Command\Joueur;

use muqsit\invmenu\InvMenu;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;

class TrashCommand extends Command {

    public function __construct() {
        parent::__construct("trash", "Ouvre une poubelle.");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        if ($sender instanceof Player) {

            $menu = InvMenu::create(InvMenu::TYPE_CHEST);
            $menu->readonly();
            $menu->setName("§7- §8Poubelle §7-");

            $menu->send($sender);

        }

    }

}