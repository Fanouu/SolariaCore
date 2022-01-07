<?php

namespace Solaria\Command\Admin;

use pocketmine\command\ConsoleCommandSender;
use pocketmine\entity\Human as PMHuman;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityMotionEvent;
use pocketmine\Player;

class NPCHuman extends PMHuman {

    use NPCMove;
    protected $sender;

    public function initEntity(): void {

        parent::initEntity();
        $this->setHealth(1);
        $this->setMaxHealth(1);

    }

    public function attack(EntityDamageEvent $event): void {

        if ($event instanceof EntityDamageByEntityEvent) {
            $damager = $event->getDamager();
            if ($damager instanceof Player) {
                if ($damager->getInventory()->getItemInHand()->getId() == 511) {
                    $event->getEntity()->kill();
                    return;
                }
                $event->setCancelled(true);
                if($this->namedtag->offsetExists("PlayerCommand")) {
                    $damager->getServer()->dispatchCommand($damager, $this->namedtag->getString("PlayerCommand"));
                } else {
                    $damager->getServer()->dispatchCommand(new ConsoleCommandSender(), str_replace("{player}", '"' . $damager->getName() . '"', $this->namedtag->getString("ConsoleCommand")));
                }
            }
        }

    }
    public function Motion(EntityMotionEvent $event): void{

        $event->setCancelled(true);

    }

}