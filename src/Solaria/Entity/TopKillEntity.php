<?php

namespace Solaria\Entity;

use pocketmine\level\Level;
use pocketmine\entity\Human;
use pocketmine\entity\Skin;
use pocketmine\nbt\tag\CompoundTag;
use Solaria\Core;
use pocketmine\event\entity\EntityDamageEvent;

class TopKillEntity extends Human{
    
    public function __construct(Level $level, CompoundTag $nbt){
        parent::__construct($level, $nbt);
    }
    
    public function onUpdate(int $currentTick): bool{
        $this->setInvisible(false);
        $this->setScale(0.001);
        $topdeath = Core::getTopKill();
        
        $message = [];
        $i = 1;
        arsort($topdeath, SORT_NUMERIC);
        foreach($topdeath as $player => $kill){
            if($i < 10){
                $message[] = "$i# §1- §9$player §1avec §9$kill kill(s) §1-§f";
            }
            $i++;
        }
        $imp = implode("\n", $message);
        $this->setNameTag("§1- §fTop kill de §9Solaria §1\n§f" . $imp);
        return parent::onUpdate($currentTick);
    }
    
    public function attack(EntityDamageEvent $event): void{
        $event->setCancelled(true);
    }
    
    public function getName(): string{
        return "TopKillEntity";
    }
    
}