<?php

namespace Solaria\Command\Admin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\level\Position;
use pocketmine\Player;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class NPCCommand extends Command {

    public function __construct() {
        parent::__construct("npc", "Fais spawn des npc.");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!($sender instanceof Player)) return;
        if(!($sender->hasPermission(Permissions::NPC)))return $sender->sendMessage(Utils::getPrefix() . "§cVous n'avez pas la permission d'utiliser cette commande.");
        if(!(isset($args[0])) or !(isset($args[1])) or !(isset($args[2])) or !(isset($args[3])))return $sender->sendMessage(Utils::getPrefix() . "Usage: §b/npc (nom) (taille) (player/console) (commande)");
        if(!($args[1] >= 0.1 and ($args[1] <= 2)))return $sender->sendMessage(Utils::getPrefix() . "§cVeuillez spécifier une taille entre 0.1 et 3 !");
        $EntityCommand = "";
        for ($i = 3; $i < count($args); $i++) {
            $EntityCommand .= " " . $args[$i];
        }
        $position = new Position(round($sender->x)+0.5, $sender->y, round($sender->z)+0.5, $sender->level);
        $nbt = Entity::createBaseNBT($position, null, $sender->getYaw(), $sender->getPitch());
        $skinTag = $sender->namedtag->getCompoundTag("Skin");
        assert($skinTag !== null);
        $nbt->setTag(clone $skinTag);
        $entity = Entity::createEntity("NPCHuman", $sender->level, $nbt);
        $entity->setNameTag($args[0]);
        $entity->setScale($args[1]);
        $entity->setImmobile(true);
        $entity->setNameTagAlwaysVisible(true);
        if(strtolower($args[2]) == "player"){
            $entity->namedtag->setString("PlayerCommand", $EntityCommand);
        } else {
            $entity->namedtag->setString("ConsoleCommand", $EntityCommand);
        }
        $entity->spawnToAll();
        return true;
    }

}