<?php

namespace Solaria\Protection;

use pocketmine\block\Block;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerBucketEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\Item;
use pocketmine\level\particle\EnchantmentTableParticle;
use pocketmine\math\Vector3;
use pocketmine\Player;
use Solaria\API\StaffModeAPI;
use Solaria\Command\Admin\NPCHuman;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class Protection implements Listener {

    public function isProtectZone(Vector3 $pos, $type = "spawn") {

        if($type === "spawn") {
            $minXSpawn = -60;
            $maxXSpawn = 60;
            $minZSpawn = -60;
            $maxZSpawn = 60;
        } else {
            $minXSpawn = -256;
            $maxXSpawn = 256;
            $minZSpawn = -256;
            $maxZSpawn = 256;
        }

        return ($pos->getX() <= $maxXSpawn && $pos->getX() >= $minXSpawn) && ($pos->getZ() <= $maxZSpawn && $pos->getZ() >= $minZSpawn);

    }

    public function onBreak(BlockBreakEvent $event) {

        $block = $event->getBlock();
        $player = $event->getPlayer();

        if(!$player->hasPermission(Permissions::PROTECTION_BYPASS)) {

            if ($block->getLevel()->getName() == "word") {

                if ($this->isProtectZone($block->asVector3(), "warzone")) {

                    $player->sendMessage(Utils::getPrefix() . "§cVous n'avez pas la permission de casser des blocs. (§eadmin.protection§c).");
                    $event->setCancelled(true);
                    $block->getLevel()->addParticle(new EnchantmentTableParticle($block->asVector3()->add(0, 1)));

                }

            }

        }

    }

    public function onPlace(BlockPlaceEvent $event) {

        $block = $event->getBlock();
        $player = $event->getPlayer();

        if(!$player->hasPermission(Permissions::PROTECTION_BYPASS)) {

            if($block->getLevel()->getName() == "word") {

                if ($this->isProtectZone($player->asVector3(), "warzone")) {

                    $player->sendMessage(Utils::getPrefix() . "§cVous n'avez pas la permission de poser des blocs. (§eadmin.protection§c).");
                    $event->setCancelled(true);
                    $block->getLevel()->addParticle(new EnchantmentTableParticle($block->asVector3()->add(0, 1)));

                }

            }

        }

    }

    public function onDamage(EntityDamageEvent $event) {

        $player = $event->getEntity();

        if ($this->isProtectZone($player->asVector3(), "spawn")) {

            if($event instanceof EntityDamageByEntityEvent) {

                if($player instanceof Player && $event->getDamager() instanceof Player) {

                    if($player instanceof Player && !$player instanceof NPCHuman) {

                        if (!StaffModeAPI::isStaffMode($player)) {

                            $event->getDamager()->sendMessage(Utils::getPrefix() . "§cVous n'avez pas la permission de taper des gens dans cette zone.");
                            $event->setCancelled(true);

                        }else{

                            $event->setCancelled(false);

                        }

                    }

                }

            } else {

                $event->setCancelled(true);

            }

        }

    }

    public function onInteract(PlayerInteractEvent $event)
    {

        $block = $event->getBlock();
        $player = $event->getPlayer();
        $item = $event->getItem();

        if(!$player->hasPermission(Permissions::PROTECTION_BYPASS)) {

            if ($block->getLevel()->getName() == "word") {

                if ($this->isProtectZone($block->asVector3(), "warzone")) {

                    if ($block->getId() == Block::FURNACE or
                        $block->getId() == Block::WATER_LILY or
                        $block->getId() == Block::WATER or
                        $block->getId() == Block::STILL_WATER or
                        $block->getId() == Block::FLOWING_WATER or
                        $block->getId() == Block::LAVA or
                        $block->getId() == Block::STILL_LAVA or
                        $block->getId() == Block::FLOWING_LAVA or
                        $block->getId() == Block::BREWING_STAND_BLOCK or
                        $block->getId() == Block::DIRT or
                        $block->getId() == Block::GRASS or
                        $block->getId() == Block::WOOD or
                        $block->getId() == Block::PLANKS or
                        $block->getId() == Block::LEAVES or
                        $block->getId() == Block::WOOL or
                        $block->getId() == Block::TRAPDOOR) {

                        $event->setCancelled(true);
                        $player->sendMessage(Utils::getPrefix() . "§cVous ne pouvez pas interagir avec ce type de blocs ! (§eadmin.protection§c).");

                    } else if($item->getId() == Item::BUCKET or
                        $item->getId() == Item::FLINT_AND_STEEL or
                        $item->getId() == Item::EGG) {

                        $event->setCancelled(true);
                        $player->sendMessage(Utils::getPrefix() . "§cVous ne pouvais pas interagir avec ce type d'items ! (§eadmin.protection§c).");

                    }

                }

            }

        }

    }

    public function useItem(PlayerBucketEvent $event)
    {

        $item = $event->getItem();
        $player = $event->getPlayer();

        $b = $event->getBlockClicked();

        if ($item->getId() == Item::BUCKET) {

            if(!$player->hasPermission(Permissions::PROTECTION_BYPASS)) {

                if ($event->getBlockClicked()->getLevel()->getName() == "word") {

                    if ($this->isProtectZone($b->asVector3(), "warsone")) {

                        $event->setCancelled(true);

                    }

                }

            }

        }

    }
    public function enderchestinterract(PlayerInteractEvent $event) {

        $block = $event->getBlock();
        $player = $event->getPlayer();
        $item = $event->getItem();

        if ($block->getId() === Block::ENDER_CHEST) {

            if (!$player->hasPermission(Permissions::ENDERCHEST_INTERACT)) {

                if ($this->isProtectZone($block->asVector3(), "spawn")) {

                    $event->setCancelled(true);
                    $player->sendMessage(Utils::getPrefix() . "§cVous n'avez pas la permission d'ouvir l'enderchest.");

                }

            }

        }

    }

}