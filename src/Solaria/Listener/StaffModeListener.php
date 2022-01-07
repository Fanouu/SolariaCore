<?php

namespace Solaria\Listener;

use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\inventory\InventoryPickupItemEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDropItemEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\Item;
use pocketmine\Player;
use Solaria\API\StaffModeAPI;
use Solaria\Core;
use Solaria\Utils\Utils;

class StaffModeListener implements Listener {

    public function invetoryPickup(InventoryPickupItemEvent $event)
    {

        $player = $event->getInventory()->getHolder();

        if ($player instanceof Player) {

            if (StaffModeAPI::isStaffMode($player)) {

                $event->setCancelled(true);

            }

        }

    }

    public function itemDrop(PlayerDropItemEvent $event)
    {

        $player = $event->getPlayer();

        if ($player instanceof Player) {

            if (StaffModeAPI::isStaffMode($player)) {

                $event->setCancelled(true);
            }

        }
    }

    public function playerQuit(PlayerQuitEvent $event)
    {

        $sender = $event->getPlayer();

        if ($sender instanceof Player) {

            if (StaffModeAPI::isStaffMode($sender)) {

                StaffModeAPI::removeStaffMode($sender);

            }

        }

    }

    public function entityDamageByEntity(EntityDamageByEntityEvent $event)
    {
        $player = $event->getEntity();
        $damager = $event->getDamager();

        if ($player instanceof Player and $damager instanceof Player) {
            if (StaffModeAPI::isStaffMode($damager)) {
                switch ($damager->getInventory()->getItemInHand()->getId()) {
                    case Item::PACKED_ICE:
                        if ($player->isImmobile()) {
                            $player->setImmobile(false);
                            $damager->sendMessage(Utils::getPrefix() . "Le joueur §b{$player->getName()} §7a été dégelé avec succès !");
                        } else {
                            $player->setImmobile(true);
                            $player->sendMessage(Utils::getPrefix() . "Vous avez été freeze par §b{$damager->getName()}");
                            $damager->sendMessage(Utils::getPrefix() . "Le joueur §b{$player->getName()} §7a été gelé avec succès !");
                        }
                        $event->setCancelled(true);
                        break;
                    case Item::CHEST:
                        StaffModeAPI::checkInv($player, $damager);
                        $event->setCancelled(true);
                        break;
                    /*case Item::DRAGON_BREATH:
                        StaffAPI::
                        break;*/
                    case Item::STICK:
                        $event->setCancelled(false);
                        break;
                    default:
                        $event->setCancelled(true);
                        break;
                }
            }
        } else {
            return;
        }

    }
    public function entityDamage(EntityDamageEvent $event) {
        $player = $event->getEntity();

        if ($player instanceof Player) {
            if (StaffModeAPI::isStaffMode($player)) {
                $event->setCancelled(true);
            }
        }
    }

    public function onInteract(PlayerInteractEvent $event) {
        $player = $event->getPlayer();

        if ($player instanceof Player) {
            if (StaffModeAPI::isStaffMode($player)) {
                switch ($player->getInventory()->getItemInHand()->getId()) {
                    case Item::BOOK:
                        $players = Core::getInstance()->getServer()->getOnlinePlayers();
                        $random = $players[array_rand($players)];
                        while ($random === $player) {
                            $random = $players[array_rand($players)];
                        }

                        $player->teleport($random);
                        $player->sendMessage(Utils::getPrefix() . "Vous avez été téléporté vers §b{$random->getName()}");
                        break;
                    case Item::PAPER:
                        if ($player->getGamemode() != 3) {
                            $player->setGamemode(3);
                            $player->sendMessage(Utils::getPrefix() . "Vous êtes désormais en mode §bSpectateur§7.");
                        } else {
                            $player->setGamemode(2);
                            $player->setAllowFlight(true);
                            $player->setAllowMovementCheats(true);
                            $player->sendMessage(Utils::getPrefix() . "Vous n'êtes désormais plus en mode §bSpectateur§7.");
                        }
                        break;
                }
            }
        }
    }

}