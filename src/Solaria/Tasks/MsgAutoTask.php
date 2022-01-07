<?php

namespace Solaria\Tasks;

use pocketmine\scheduler\Task;
use Solaria\Core;
use Solaria\Utils\Utils;

class MsgAutoTask extends Task{
    public $time = 2000;
    public function __construct(){}
    public function onRun(int $currentTick)
    {
        switch ($this->time){
            case 0:
                $this->time = 2000;
                Core::getInstance()->getServer()->broadcastMessage("§1[§9§l!!!§r§1] §fEnvie d'avoir un §9Grade / Particules / Clés §f? On accepte désormais les §aPaySafeCard §f et aussi les payements via §9PayPal §f Pour tous les achats sont disponibles sur le discord de §6Solaria §f!");
                break;
            case 750:
                Core::getInstance()->getServer()->broadcastMessage("§1[§9§l?§1]§f Envie d'obtenir des récompense Gratuitement Ainsi que des §9Keys §f? Votez pour le serveur afin de les obtenir-> §9https://minecraftpocket-servers.com/server/111615/");
                break;
            case 1500:
                Core::getInstance()->getServer()->broadcastMessage("§1[§9§l!!!§r§1] §fVous pouvez désormais recevoir des §aJetons §fjuste en purifiant vos lingots De §9Saphir §f au §9/purif §f! ");
                break;
        }
        $this->time--;
    }
}