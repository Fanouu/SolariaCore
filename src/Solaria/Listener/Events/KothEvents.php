<?php

namespace Solaria\Listener\Events;

use Solaria\API\KothAPI;
use Solaria\Core;
use Solaria\Tasks\KothStartedTask;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Player;
use pocketmine\utils\Config;

class KothEvents implements Listener {

    public static $poskoth = [];
    private $plugin;
    
    public function __construct(Core $plugin){
      $this->plugin = $plugin;
      $this->koth_data = new Config($this->plugin->getDataFolder() . "Events/koth.json", Config::JSON);
    }

    public function onMove(PlayerMoveEvent $event) {
      
      $cfg = new Config($this->plugin->getDataFolder() . "Config.yml", Config::YAML);
      $pos1 = explode(":", $cfg->get("CordKothPos1"));

        if($this->plugin->getKothAPI()->get("koth_enable") == true) {

            $player = $event->getPlayer();

            if($this->plugin->getKothAPI()->get("capturBy") === "undefined") {

                if($player->getLevel()->getFolderName() === $pos1[0]) {

                        if($this->isInPos($player)) {

                            $this->plugin->getKothAPI()->set("capturBy", $player->getName());
                            $this->plugin->getServer()->broadcastPopup("§r§1{$player->getName()} §fcommence a capturé le §cKOTH §f!");

                        }

                }

            } else {
                if(!$this->plugin->getKothAPI()->get("capturBy") === $player->getName()){
                    $capturBy = $this->plugin->getKothAPI()->get("capturBy");
                    $player->sendPopup("§1$capturBy §r§fest déjà en train de capturer le §cKOTH§f, §9éjecte §fle de la plateforme !");
               }

                if (!$this->isInPos($player)) {

                    if ($this->plugin->getKothAPI()->get("capturBy") === $player->getName()) {
                        
                        $this->plugin->getKothAPI()->set("capturBy", "undefined");
                        
                        KothStartedTask::$number  = 0;
                    }

                }

            }

        }

    }

    public function isInPos(Player $player) {

        $cfg = new Config($this->plugin->getDataFolder() . "Config.yml", Config::YAML);
        if($cfg->get("CordKothPos1") === "undefined" or($cfg->get("CordKothPos2") === "undefined")) return $this->plugin->getLogger()->error("Les position du koth ne sont pas definit !");
        $pos1 = explode(":", $cfg->get("CordKothPos1"));
        $pos2 = explode(":", $cfg->get("CordKothPos2"));

        $minX = min($pos1[1], $pos2[1]);
        $maxX = max($pos1[1], $pos2[1]);
        $minY = min($pos1[2], $pos2[2]);
        $maxY = max($pos1[2], $pos2[2]);
        $minZ = min($pos1[3], $pos2[3]);
        $maxZ = max($pos1[3], $pos2[3]);

        if($player->getX() >= $minX && $player->getX() <= $maxX
            && $player->getY() >= $minY && $player->getY() <= $maxY
            && $player->getZ() >= $minZ && $player->getZ() <= $maxZ) {

            return true;

        } else return false;
    }
    
    public function onQuit(PlayerQuitEvent $event){
        $player  = $event->getPlayer();
        
       if ($this->plugin->getKothAPI()->get("capturBy") === $player->getName()) {
                        
               $this->plugin->getKothAPI()->set("capturBy", "undefined");
                        
               KothStartedTask::$number  = 0;
       }
    }

}