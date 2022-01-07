<?php

namespace Solaria\Tasks;

use pocketmine\command\ConsoleCommandSender;
use pocketmine\scheduler\Task;
use Solaria\Core;
use Solaria\Utils\Utils;

class MinageTask extends Task{
    public static $timeMine = 900;
    public static $timeMineVIP = 3600;
    public function __construct(){}
    public function onRun(int $currentTick)
    {
        if(self::$timeMine <= 0){
            Core::getInstance()->getServer()->broadcastMessage("§1[§9§l!!!§r§1] §fLa mine classique vien d'être reset ! ");
            Core::getInstance()->getServer()->dispatchCommand(new ConsoleCommandSender(), "mine reset Mine");
            self::$timeMine = 900;
        }
        if(self::$timeMineVIP <= 0){
            Core::getInstance()->getServer()->broadcastMessage(Utils::MINAGE . "§1[§9§l!!!§r§1] §fLa mine VIP / MVP vien d'être reset ! ");
            Core::getInstance()->getServer()->dispatchCommand(new ConsoleCommandSender(), "mine reset MineVip");
            Core::getInstance()->getServer()->dispatchCommand(new ConsoleCommandSender(), "mine reset MineMvp");
            self::$timeMineVIP = 3600;
        }
        self::$timeMine--;
        self::$timeMineVIP--;
    }
}