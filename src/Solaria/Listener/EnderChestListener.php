<?php

namespace Solaria\Listener;

use pocketmine\event\inventory\InventoryOpenEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\Listener;
use pocketmine\inventory\EnderChestInventory;
use pocketmine\item\Item;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\Player;
use Solaria\Utils\Permissions;

class EnderChestListener implements Listener {

    public function onOpenEnderchest(InventoryOpenEvent $event): void
    {
        $inv = $event->getInventory();
        $player = $event->getPlayer();

        if ($inv instanceof EnderChestInventory) {
            $this->setSlots($player, $this->getSlots($player));
        }
    }

    public function getSlots($player)
    {
        if ($player->hasPermission(Permissions::ENDERCHEST_CHAMPION)) {
            $slots = 27;
        } else if ($player->hasPermission(Permissions::ENDERCHEST_VIP)) {
            $slots = 18;
        }  else {
            $slots = 9;
        }
        return $slots;
    }


    public function onEnderchestTransaction(InventoryTransactionEvent $e): void
    {
        $transactions = $e->getTransaction()->getActions();
        foreach ($transactions as $transaction){
            $item =$transaction->getSourceItem();
            $nbt = ($item->getNamedTag() ?? new CompoundTag());
            $item1 =$transaction->getTargetItem();
            $nbt1 = ($item1->getNamedTag() ?? new CompoundTag());
            foreach ($e->getTransaction()->getInventories() as $inv){
                if ($inv instanceof EnderChestInventory) {
                    if($nbt->hasTag("Restricted") || $nbt1->hasTag("Restricted")) {
                        $e->setCancelled();
                    }
                }
            }
        }
    }

    private function setSlots(Player $player, int $slots): void
    {
        $enderchest = $player->getEnderChestInventory();

        for ($i = 1; $i <= 26; $i++){
            $item = $player->getEnderChestInventory()->getItem($i);
            $nbt = ($item->getNamedTag() ?? new CompoundTag());

            if($nbt->hasTag("Restricted")){
                $enderchest->setItem($i, Item::get(0, 0, 1), true);
            }

            if($slots <= $i){
                if($item->getId() == 0 or $item->getId() == 437 or $item->getId() == 160){
                    $glass = Item::get(160, 15, 1);
                    $glass->setCustomName("§7- §cBloqué §7-");

                    $nbt = ($glass->getNamedTag() ?? new CompoundTag());
                    $nbt->setString("Restricted", "true");
                    $glass->setNamedTag($nbt);
                    $enderchest->setItem($i, $glass);
                    $slots++;
                }
            }
        }
    }

}