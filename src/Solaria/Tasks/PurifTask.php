<?php

namespace Solaria\Tasks;

use onebone\economyapi\EconomyAPI;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\scheduler\Task;
use Solaria\Utils\Permissions;
use Solaria\Utils\Purif;
use Solaria\Core;

class PurifTask extends Task{
    public $time = 10;
    public $p;
    public function __construct(Player $p)
    {
        $this->p = $p;
    }
    public function onRun(int $currentTick)
    {
        $p = $this->p;
        if(Purif::$pl[$p->getName()] == "non") return Core::getInstance()->getScheduler()->cancelTask($this->getTaskId());
        $inv = $p->getInventory();
        if($inv->getItemInHand()->getId() == 266){
            if($this->time == 0){
            $inv->setItemInHand($inv->getItemInHand()->setCount($inv->getItemInHand()->getCount() - 1));
            $r = random_int(1, 10);
            $b = 0;
            if($p->hasPermission(Permissions::PURIFVIP)){
                if ($p->hasPermission(Permissions::PURIFMVP)) {
                    if ($p->hasPermission(Permissions::PURIFSUPREME)) {
                        $r = $r * 2;
                        $b = 2;
                    } else {
                        $r = $r * 1.5;
                        $b = 1.5;
                    }
                }else{
                    $r = $r*1.25; $b = 1.25;
                }
            }else{
                $b = 0;
            }
            EconomyAPI::getInstance()->addMoney($p, $r);
            Core::getInstance()->getLogger()->info("{$p->getName()} a purifier {$r}");
            $p->sendPopup("§l» §9+{$r} (§1x{$b}§9) §l«");
            Purif::$purif_anti[$p->getName()] = 10;
            $this->time = 10;
        }else{
            switch($this->time){
                case 1:
                    $p->sendPopup("§l» §r§9Chargement: §a||||||||||||||||||§c||");
                    break;
                case 2:
                    $p->sendPopup("§l» §r§9Chargement: §a||||||||||||||||§c||||");
                    break;
                case 3:
                    $p->sendPopup("§l» §r§9Chargement: §a||||||||||||||§c||||||");
                    break;
                case 4:
                    $p->sendPopup("§l» §r§9Chargement: §a||||||||||||§c||||||||");
                    break;
                case 5:
                    $p->sendPopup("§l» §r§9Chargement: §a||||||||||§c||||||||||");
                    break;
                case 6:
                    $p->sendPopup("§l» §r§9Chargement: §a||||||||§c||||||||||||");
                    break;
                case 7:
                    $p->sendPopup("§l» §r§9Chargement: §a||||||§c||||||||||||||");
                    break;
                case 8:
                    $p->sendPopup("§l» §r§9Chargement: §a||||§c||||||||||||||||");
                    break;
                case 9:
                    $p->sendPopup("§l» §r§9Chargement: §a||§c||||||||||||||||||");
                    break;
                case 10:
                    $p->sendPopup("§l» §r§9Chargement: §c§c||||||||||||||||||||");
                    break;
            }
            $this->time--;
            Purif::$purif_anti[$p->getName()]--;
            if(Purif::$purif_anti[$p->getName()] < 0){
                Core::getInstance()->getScheduler()->cancelTask($this->getTaskId());
                $p->sendPopup("§l» §r§9Une erreur s'est produite merci de sortir et de rentrer dans la zone");
                Purif::$pl[$p->getName()] = "non";
            }
        }
        }else{
            $p->sendPopup("§l» §r§9Merci de mettre du §1saphir§9 en main !");
        }
        return true;
    }
}