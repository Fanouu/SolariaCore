<?php

namespace Solaria\Listener;

use pocketmine\event\entity\ProjectileHitBlockEvent;
use pocketmine\event\entity\ProjectileHitEntityEvent;
use pocketmine\event\Listener;
use pocketmine\level\sound\EndermanTeleportSound;
use pocketmine\Player;

class PearlCooldownListener implements Listener{
    public $time = [];
    public function onHitB(ProjectileHitBlockEvent $e){
        $entity = $e->getEntity();
        $name = (new \ReflectionClass($entity))->getShortName();
        if("Ender" == $name){
            $p = $entity->getOwningEntity();
            if($p instanceof Player){
                if(time() > $this->time[$p->getName()]){
                    $p->teleport($e->getBlockHit());
                    $this->time[$p->getName()] = time() + 15;
                }else{
                    $e->setCancelled(true);
                    $t = $this->time[$p->getName()] - time();
                    $p->sendPopup("§c> §7Encore {$t} secondes §c<");
                }
            }
        }
    }
    public function onHitE(ProjectileHitEntityEvent $e){
        $entity = $e->getEntity();
        $name = (new \ReflectionClass($entity))->getShortName();
        if("Ender" == $name){
            $p = $entity->getOwningEntity();
            if($p instanceof Player){
                if(time() > $this->time[$p->getName()]){
                    $p->teleport($e->getEntityHit());
                    $this->time[$p->getName()] = time() + 15;
                }else{
                    $e->setCancelled(true);
                    $t = $this->time[$p->getName()] - time();
                    $p->sendPopup("§c> §7Encore {$t} secondes §c<");
                }
            }
        }
    }
}