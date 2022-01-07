<?php

namespace Solaria\API;

use muqsit\invmenu\InvMenu;
use pocketmine\item\Item;
use pocketmine\Player;
use Solaria\Core;
use Solaria\Utils\Permissions;

class StaffModeAPI {

    private static $armor = [];
    private static $invetory = [];
    /**
     * @var array
     */
    private static $nametag = [];

    public static function setStaffMode(Player $sender){

        self::$armor[$sender->getName()] = $sender->getArmorInventory()->getContents();
        self::$invetory[$sender->getName()] = $sender->getInventory()->getContents();
        $rank = Core::getRankAPI()->getRank($sender);
        $grade = Core::getRankAPI()->getRankColored($sender);
        self::$nametag[$sender->getName()] = Core::getRankAPI()->getNametag($sender, $rank);
        $sender->getInventory()->clearAll();
        $sender->getArmorInventory()->clearAll();
        $sender->removeAllEffects();
        $sender->setGamemode(2);
        $sender->setAllowFlight(true);
        $sender->setAllowMovementCheats(true);
        $sender->setFood(20);
        $sender->setSaturation(20);

        //StaffModeItem

        $gamemode3 = Item::get(Item::PAPER, 0, 1);
        $randomTP = Item::get(Item::BOOK, 0, 1);
        $freeze = Item::get(Item::PACKED_ICE, 0, 1);
        $knockback = Item::get(Item::STICK, 0, 1);
        $gamemode3->setCustomName("§7- §bGAMEMODE 3 §7-");
        $randomTP->setCustomName("§7- §bRANDOM TP §7-");
        $freeze->setCustomName("§7- §bFREEZE §7-");
        $knockback->setCustomName("§7- §bKNOCKBACK §7-\n§b(taper le joueur)");

        $sender->getInventory()->setItem(0, $gamemode3);
        $sender->getInventory()->setItem(2, $randomTP);
        $sender->getInventory()->setItem(4, $freeze);
        $sender->getInventory()->setItem(8, $knockback);
        $sender->setNameTag("§7[§bVanish§7] {$sender->getName()}");

        foreach (Core::getInstance()->getServer()->getOnlinePlayers() as $player) {

            if (!$player->hasPermission(Permissions::VANISH)) {

                $player->hidePlayer($sender);
                $player->getServer()->removePlayerListData($sender->getUniqueId());
                $player->sendMessage("§7[§c-§7] [{$grade}§7] {$sender->getDisplayName()}");
            }

        }

    }

    public static function removeStaffMode(Player $sender) {

        if (self::isStaffMode($sender)) {

            $grade = Core::getRankAPI()->getRankColored($sender);
            $sender->getInventory()->clearAll();
            $sender->getArmorInventory()->clearAll();
            $sender->removeAllEffects();
            $sender->getArmorInventory()->setContents(self::$armor[$sender->getName()]);
            $sender->getInventory()->setContents(self::$invetory[$sender->getName()]);
            $sender->setNameTag(self::$nametag[$sender->getName()]);
            unset(self::$nametag[$sender->getName()]);
            unset(self::$armor[$sender->getName()]);
            unset(self::$invetory[$sender->getName()]);
            $sender->setAllowMovementCheats(false);
            $sender->setAllowFlight(false);
            $sender->teleport(Core::getInstance()->getServer()->getDefaultLevel()->getSafeSpawn());
            $sender->setGamemode(0);
            $sender->getServer()->updatePlayerListData($sender->getUniqueId(), $sender->getId(), $sender->getDisplayName(), $sender->getSkin(), $sender->getXuid());
            foreach (Core::getInstance()->getServer()->getOnlinePlayers() as $player) {

                $player->showPlayer($sender);
                $player->sendMessage("§7[§a+§7] [{$grade}§7] {$sender->getName()}");

            }

        }

    }

    public static function isStaffMode(Player  $sender) {

        return isset(self::$invetory[$sender->getName()]);

    }

    public static function checkInv(Player $player, Player $staff) {
        $menu = InvMenu::create(InvMenu::TYPE_DOUBLE_CHEST);
        $glass = Item::get(437, 0, 1);
        $glass->setCustomName("§c---");
        $menu->getInventory()->setItem(36, $glass);
        $menu->getInventory()->setItem(37, $glass);
        $menu->getInventory()->setItem(38, $glass);
        $menu->getInventory()->setItem(39, $glass);
        $menu->getInventory()->setItem(40, $glass);
        $menu->getInventory()->setItem(41, $glass);
        $menu->getInventory()->setItem(42, $glass);
        $menu->getInventory()->setItem(43, $glass);
        $menu->getInventory()->setItem(44, $glass);
        $glass->setCustomName("§cCasque ->");
        $menu->getInventory()->setItem(45, $glass);
        $glass->setCustomName("§c<- Casque | Plastron ->");
        $menu->getInventory()->setItem(47, $glass);
        $glass->setCustomName("§c<- Plastron | Pantalon ->");
        $menu->getInventory()->setItem(49, $glass);
        $glass->setCustomName("§c<- Pantalon | Bottes ->");
        $menu->getInventory()->setItem(51, $glass);
        $glass->setCustomName("§c<- Bottes");
        $menu->getInventory()->setItem(53, $glass);
        foreach($player->getInventory()->getContents() as $value => $item){
            $menu->getInventory()->setItem($value, $item);
        }
        $menu->getInventory()->setItem(46, $player->getArmorInventory()->getHelmet());
        $menu->getInventory()->setItem(48, $player->getArmorInventory()->getChestplate());
        $menu->getInventory()->setItem(50, $player->getArmorInventory()->getLeggings());
        $menu->getInventory()->setItem(52, $player->getArmorInventory()->getBoots());
        $menu->setName("§7- §8Inventaire de §b{$player->getName()} §7-");
        //$menu->setListener(InvMenu::readonly());
        $menu->send($staff);
    }

}