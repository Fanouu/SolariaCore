<?php

namespace Solaria\Listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\utils\Config;

use Solaria\Core;

class PlayerDeath implements Listener{
    private $plugin;

    public function __construct(Core $plugin){
        $this->plugin = $plugin;
    }

    public function playerDeath(PlayerDeathEvent $event){
        $player = $event->getPlayer();
        $pname = $player->getName();
        
        $event->setDeathMessage("");

        $cause = $player->getLastDamageCause()->getCause();
       if($cause === EntityDamageByEntityEvent::CAUSE_ENTITY_ATTACK){
          $killer = $player->getLastDamageCause()->getDamager()->getName();
   
          $random = mt_rand(1, 7);
          $this->setData($killer, "kill", 1);
          $this->setData($pname, "death", 1);
        $player->getServer()->broadcastMessage("§b$killer §9à tué §c$pname");
      }else{
           $player->getServer()->broadcastMessage("§c$pname §9est mort");
       }
    }
    
    public function setData($player, $type, int $num){
        if($type === "death"){
            $data = new Config(Core::getInstance()->getDataFolder() . "Top/TopDeath.yml", Config::YAML);
            $data->set($player, $data->get($player) + $num);
            $data->save();
        }
        
        if($type === "kill"){
            $data = new Config(Core::getInstance()->getDataFolder() . "Top/TopKill.yml", Config::YAML);
            $data->set($player, $data->get($player) + $num);
            $data->save();
        }
    }
}