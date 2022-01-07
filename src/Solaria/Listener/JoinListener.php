<?php

namespace Solaria\Listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\item\Item;

class JoinListener implements Listener{
  
  public function onInteract(PlayerInteractEvent $event){
    $player = $event->getPlayer();
    $id = $event->getItem()->getId();
    if($id === 357){
      $player->getInventory()->removeItem(Item::get(357, 0, 1));
      $player->addEffect(new EffectInstance(Effect::getEffect(Effect::STRENGTH), 10*60*20, 0));
      $player->addEffect(new EffectInstance(Effect::getEffect(Effect::SPEED), 10*60*20, 0));
      $player->addEffect(new EffectInstance(Effect::getEffect(Effect::REGENERATION), 10*20, 0));
    }
  }
}