<?php

namespace Solaria\Command\Admin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Solaria\Core;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class BroadcastCommand extends Command{
    public function __construct(){
        parent::__construct("broadcast", "Permet de mettre un message à tous les joueurs");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender->hasPermission(Permissions::BROADCAST)) return $sender->sendMessage(Utils::getPrefix() . "Tu n'as pas la permission de faire ceci");
        if (count($args) < 1) return $sender->sendMessage(Utils::getPrefix() . "Usage: §b/broadcast <message>§7.");
        $message = [];
        for ($i = 0; $i < count($args); $i++) {
            array_push($message, $args[$i]);
        }
        $message = implode(" ", $message);
        Core::getInstance()->getServer()->broadcastMessage(Utils::getPrefix() . $message);
        return true;
    }
}