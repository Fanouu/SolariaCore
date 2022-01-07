<?php

namespace Solaria\Tasks;

use pocketmine\command\ConsoleCommandSender;
use pocketmine\Server;
use pocketmine\scheduler\Task;
use Solaria\Core;
use pocketmine\utils\Config;
use Solaria\Utils\Utils;

class KothTask extends Task{

    private $plugin;

    public function __construct(Core $plugin){
        $this->plugin = $plugin;
        $this->koth_data = new Config($this->plugin->getDataFolder() . "Events/koth.json", Config::JSON);
        $this->cfg = new Config($this->plugin->getDataFolder() . "Config.yml", Config::YAML);
    }

    public function onRun(int $currentTick){
        $timer = intval($this->koth_data->get("koth_nexTime") - time());
          $heures = $this->plugin->getKothAPI()->getRestantTime("h");
        
        $minutes = $this->plugin->getKothAPI()->getRestantTime("m");
        $sec = $this->plugin->getKothAPI()->getRestantTime("s");
        

        $timeKoth = $this->plugin->getKothAPI()->get("koth_nexTime");
        if(!$timeKoth or($timeKoth <= 0)){
            $this->plugin->getKothAPI()->set("koth_nexTime", time() + $this->cfg->get("KothApparitionDelait")*60*60);
            
            //$this->plugin->getKothAPI()->set("koth_nexTime", time() + 30);
           
        }
        
        if($heures == 0){
        if($minutes === 45 and($sec == 50)){
            Server::getInstance()->broadcastMessage("§1[§9§l!!!§r§1] §fL'événement Koth est disponible dans §c45 minutes §f!");
        }

        if($minutes === 30 and($sec == 50)){
            Server::getInstance()->broadcastMessage("§1[§9§l!!!§r§1] §fL'événement Koth est disponible dans §c30 minutes §f!");
        }

        if($minutes === 15 and($sec == 50)){
            Server::getInstance()->broadcastMessage("§1[§9§l!!!§r§1] §fL'événement Koth est disponible dans §c15 minutes §f!");
        }

        if($minutes == 0 and($this->plugin->getKothAPI()->get("koth_enable") == false)){
            $this->plugin->getKothAPI()->start();
            Utils::sendWebHook("Un événement **KOTH** vient de démarrer, soyez le premier à capturer la zone !", "**Event KOTH**", "drop_your_webhook_link");
        }
        }


    }
}
