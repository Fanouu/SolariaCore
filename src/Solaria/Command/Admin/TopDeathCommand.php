<?php

namespace Solaria\Command\Admin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\level\Position;
use pocketmine\Player;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;
use Solaria\Core;
use pocketmine\Server;
use Solaria\Entity\TopDeathEntity;

class TopDeathCommand extends Command {

    public function __construct() {
        parent::__construct("topdeath", "topdeath");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!($sender instanceof Player)) return;
        if(!isset($args[0])){
            $topkill = Core::getTopDeath();
            $sender->sendMessage("§9Top §110 §9des joueur aillant le plus de §1mort");
            $i = 1;
            arsort($topkill, SORT_NUMERIC);
            foreach($topkill as $player => $kill){
                if($i < 10){
                    $sender->sendMessage("$i# §1- §9$player §1avec §9$kill mort(s) §1-");
                }
                $i++;
            }
        }else{
            switch($args[0]){
                case "spawn":
                    if($sender->hasPermission("spawn.stats.solaria")){
                        $position = $sender->asVector3();
                        $nbt = Entity::createBaseNBT($position);
                        $skinTag = $sender->namedtag->getCompoundTag("Skin");
                        assert($skinTag !== null);
                        $nbt->setTag(clone $skinTag);
                        $entity = Entity::createEntity("TopDeathEntity", $sender->level, $nbt);
                        $entity->setScale(0.001);
                        $entity->setImmobile(true);
                        $entity->setNameTagAlwaysVisible(true);
                        $entity->spawnToAll();
                    }else{
                        $sender->sendMessage("§cVous n'avez pas les permissions");
                    }
                break;
                    
                case "delete":
                    if($sender->hasPermission("delete.stats.solaria")){
                    foreach(Server::getInstance()->getLevels() as $level){
                       foreach($level->getEntities() as $entities){
                            if($entities instanceof TopDeathEntity){
                                $entities->flagForDespawn();
                                $sender->sendMessage($entities->getName() . " was deleted");
                            }
                        }
                    }
                    }
                 break;
            }
        }
        return true;
    }

}