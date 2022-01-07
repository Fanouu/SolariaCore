<?php

namespace Solaria\Utils;

use pocketmine\block\BlockIds;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\level\particle\FloatingTextParticle;
use pocketmine\math\Vector3;
use pocketmine\tile\Chest;
use Solaria\Core;
use const http\Client\Curl\Features\LARGEFILE;

class Larguage{
    public static function chest(){
        self::chest1(); self::chest2(); self::chest3(); self::chest4(); self::chest5(); self::chest6(); self::chest7(); self::chest8(); self::chest9(); self::chest10();
    }
    public static $chest1 = [
        "264:3:3",
        "332:16:6",
        "314:1:9:§fCasque en §1Saphir",
        "388:3:15",
        "264:4:24"
    ];
    public static function chest1(){
        $t = Core::getInstance()->getServer()->getDefaultLevel()->getTile(new Vector3(117, 51, -121));
        if(!$t instanceof Chest) return Core::getInstance()->getLogger()->alert("Chest 1 bug");
        foreach (self::$chest1 as $c){
            $c = explode(":", $c);
            $i = Item::get($c[0], 0, $c[1]);
            $n = $c[3] ?? $i->getName();
            $i->setCustomName($n);
            $t->getRealInventory()->setItem($c[2], $i);
        }
    }

    public static $chest2 = [
        "388:4:11",
        "264:4:15",
        "332:16:18",
        "283:1:21"
    ];
    public static function chest2(){
        $t = Core::getInstance()->getServer()->getDefaultLevel()->getTile(new Vector3(115, 51, -143));
        if(!$t instanceof Chest) return Core::getInstance()->getLogger()->alert("Chest 2 bug");
        foreach (self::$chest2 as $c){
            $c = explode(":", $c);
            $i = Item::get($c[0], 0, $c[1]);
            $n = $c[3] ?? $i->getName();
            $i->setCustomName($n);
            $t->getRealInventory()->setItem($c[2], $i);
        }
    }

    public static $chest3 = [
        "332:16:18",
        "388:10:20",
        "317:1:22:§fBottes en §1Saphir",
        "264:6:25",
        "264:6:27"
    ];
    public static function chest3(){
        $t = Core::getInstance()->getServer()->getDefaultLevel()->getTile(new Vector3(136, 51, -145));
        if(!$t instanceof Chest) return Core::getInstance()->getLogger()->alert("Chest 3 bug");
        foreach (self::$chest3 as $c){
            $c = explode(":", $c);
            $i = Item::get($c[0], 0, $c[1]);
            $n = $c[3] ?? $i->getName();
            $i->setCustomName($n);
            $t->getRealInventory()->setItem($c[2], $i);
        }
    }

    public static $chest4 = [
        "264:12:7",
        "388:10:10",
        "332:16:24",
    ];
    public static function chest4(){
        $t = Core::getInstance()->getServer()->getDefaultLevel()->getTile(new Vector3(144, 51, -129));
        if(!$t instanceof Chest) return Core::getInstance()->getLogger()->alert("Chest 4 bug");
        foreach (self::$chest4 as $c){
            $c = explode(":", $c);
            $i = Item::get($c[0], 0, $c[1]);
            $n = $c[3] ?? $i->getName();
            $i->setCustomName($n);
            $t->getRealInventory()->setItem($c[2], $i);
        }
    }

    public static $chest5 = [
        "264:6:1",
        "388:10:5",
        "332:16:7",
        "317:1:19:§fBottes en §1Saphir",
        "332:1:25"
    ];
    public static function chest5(){
        $t = Core::getInstance()->getServer()->getDefaultLevel()->getTile(new Vector3(125, 51, -136));
        if(!$t instanceof Chest) return Core::getInstance()->getLogger()->alert("Chest 5 bug");
        foreach (self::$chest5 as $c){
            $c = explode(":", $c);
            $i = Item::get($c[0], 0, $c[1]);
            $n = $c[3] ?? $i->getName();
            $i->setCustomName($n);
            $t->getRealInventory()->setItem($c[2], $i);
        }
    }

    public static $chest6 = [
        "388:6:4",
        "264:6:16",
        "283:1:19:§fEpee en §1Saphir",
        "332:16:22"
    ];
    public static function chest6(){
        $t = Core::getInstance()->getServer()->getDefaultLevel()->getTile(new Vector3(110, 51, -158));
        if(!$t instanceof Chest) return Core::getInstance()->getLogger()->alert("Chest 6 bug");
        foreach (self::$chest6 as $c){
            $c = explode(":", $c);
            $i = Item::get($c[0], 0, $c[1]);
            $n = $c[3] ?? $i->getName();
            $i->setCustomName($n);
            $t->getRealInventory()->setItem($c[2], $i);
        }
    }

    public static $chest7 = [
        "332:16:12",
        "388:10:16",
        "264:6:19",
        "388:10:23"
    ];
    public static function chest7(){
        $t = Core::getInstance()->getServer()->getDefaultLevel()->getTile(new Vector3(129, 51, -142));
        if(!$t instanceof Chest) return Core::getInstance()->getLogger()->alert("Chest 7 bug");
        foreach (self::$chest7 as $c){
            $c = explode(":", $c);
            $i = Item::get($c[0], 0, $c[1]);
            $n = $c[3] ?? $i->getName();
            $i->setCustomName($n);
            $t->getRealInventory()->setItem($c[2], $i);
        }
    }

    public static $chest8 = [
        "388:10:10",
        "332:16:16",
        "264:10:20"
    ];
    public static function chest8(){
        $t = Core::getInstance()->getServer()->getDefaultLevel()->getTile(new Vector3(126, 51, -113));
        if(!$t instanceof Chest) return Core::getInstance()->getLogger()->alert("Chest 4 bug");
        foreach (self::$chest8 as $c){
            $c = explode(":", $c);
            $i = Item::get($c[0], 0, $c[1]);
            $n = $c[3] ?? $i->getName();
            $i->setCustomName($n);
            $t->getRealInventory()->setItem($c[2], $i);
        }
    }

    public static $chest9 = [
        "332:16:15",
        "264:10:19"
    ];
    public static function chest9(){
        $t = Core::getInstance()->getServer()->getDefaultLevel()->getTile(new Vector3(103, 51, -112));
        if(!$t instanceof Chest) return Core::getInstance()->getLogger()->alert("Chest 9 bug");
        foreach (self::$chest9 as $c){
            $c = explode(":", $c);
            $i = Item::get($c[0], 0, $c[1]);
            $n = $c[3] ?? $i->getName();
            $i->setCustomName($n);
            $t->getRealInventory()->setItem($c[2], $i);
        }
    }

    public static $chest10 = [
        "388:1:5",
        "317:1:10:§fBottes en §1Saphir",
        "332:16:24",
        "264:9:25"
    ];
    public static function chest10(){
        $t = Core::getInstance()->getServer()->getDefaultLevel()->getTile(new Vector3(100, 51, -140));
        if(!$t instanceof Chest) return Core::getInstance()->getLogger()->alert("Chest 10 bug");
        foreach (self::$chest10 as $c){
            $c = explode(":", $c);
            $i = Item::get($c[0], 0, $c[1]);
            $n = $c[3] ?? $i->getName();
            $i->setCustomName($n);
            $t->getRealInventory()->setItem($c[2], $i);
        }
    }
}