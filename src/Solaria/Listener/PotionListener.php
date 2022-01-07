<?php

namespace Solaria\Listener;

use pocketmine\entity\Entity;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\nbt\tag\ShortTag;

class PotionListener implements Listener {

    public function onProjectile(PlayerInteractEvent $event)
    {
        $player = $event->getPlayer();
        $item = $event->getItem();
        if ($item->getId() == ItemIds::SPLASH_POTION) {
                if($event->isCancelled(true))return;
                $event->setCancelled(true);
                $nbt = new CompoundTag("", [
                    "Pos" => new ListTag("Pos", [
                        new DoubleTag("", $player->x),
                        new DoubleTag("", $player->y + $player->getEyeHeight()),
                        new DoubleTag("", $player->z),
                    ]),
                    "Motion" => new ListTag("Motion", [
                        new DoubleTag("", -sin($player->yaw / 180 * M_PI) * cos($player->pitch / 180 * M_PI)),
                        new DoubleTag("", -sin($player->pitch / 180 * M_PI)),
                        new DoubleTag("", cos($player->yaw / 180 * M_PI) * cos($player->pitch / 180 * M_PI)),
                    ]),
                    "Rotation" => new ListTag("Rotation", [
                        new FloatTag("", $player->yaw),
                        new FloatTag("", $player->pitch),
                    ]),
                ]);
                $nbt["PotionId"] = new ShortTag("PotionId", $item->getDamage());
                $entity = Entity::createEntity("SplashPotion", $player->getLevel(), $nbt, null);
                if ($entity != null) {
                    $entity->setMotion($entity->getMotion()->multiply(1.2));
                }
                if ($player->isSurvival()) {
                    $player->getInventory()->setItemInHand(Item::get(Item::AIR));
                }

        }
    }

}