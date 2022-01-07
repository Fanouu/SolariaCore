<?php

namespace Solaria\Tasks;

use pocketmine\command\ConsoleCommandSender;
use pocketmine\scheduler\Task;
use Solaria\Core;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use Solaria\Utils\Utils;
use pocketmine\utils\Config;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\item\Item;

class KothStartedTask extends Task{

    private $plugin;
    
    public static $number = 0;

    public function __construct(Core $plugin){
        $this->plugin = $plugin;
        $this->koth_data = new Config($this->plugin->getDataFolder() . "Events/koth.json", Config::JSON);
        $this->cfg = new Config($this->plugin->getDataFolder() . "Config.yml", Config::YAML);
        $this->economyapi = Server::getInstance()->getPluginManager()->getPlugin("EconomyAPI");
    }

    public function onRun(int $currentTick){
        
        $minutes = $this->plugin->getKothAPI()->getRestantTimeForCapture("m");
        $sec = $this->plugin->getKothAPI()->getRestantTimeForCapture("s");
        
        if(self::$number == 100){
            
            foreach (Server::getInstance()->getOnlinePlayers() as $player){
            if($player->getName() === $this->plugin->getKothAPI()->get("capturBy")){
                $helmet = Item::get(Item::GOLD_HELMET, 1);
                    $helmet->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 4));
                    $helmet->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3));
                    $player->getInventory()->addItem($helmet);

                    $chestplate = Item::get(Item::GOLD_CHESTPLATE, 1);
                    $chestplate->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 4));
                    $chestplate->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3));
                    $player->getInventory()->addItem($chestplate);
                    $leggings = Item::get(Item::GOLD_LEGGINGS, 1);
                    $leggings->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 4));
                    $leggings->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3));
                    $player->getInventory()->addItem($leggings);
                    $boots = Item::get(Item::GOLD_BOOTS, 1);
                    $boots->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 4));
                    $boots->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3));
                    $player->getInventory()->addItem($boots);

                    $sword = Item::get(Item::GOLD_SWORD, 1);
                    $sword->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::SHARPNESS), 5));
                    $player->getInventory()->addItem($sword);
                    $this->economyapi->addMoney($player, 250);
                    $player->sendPopup("§f+§6200 ");
            }
            }
          
          Core::getInstance()->getServer()->broadcastMessage("§1[§9§l!!!§r§1] §fL'événement Koth viens de ce terminé ! Bravo à §6" . $this->plugin->getKothAPI()->get("capturBy") . " §fqui win !");
          $this->plugin->getKothAPI()->stop();
          $this->plugin->getScheduler()->cancelTask($this->getTaskId());
            
            
        }
        
        if($this->plugin->getKothAPI()->get("capturBy") != "undefined"){
      
          self::$number++;
          
          if($minutes <= 2){
          self::$number++;
          }
          
          foreach (Server::getInstance()->getOnlinePlayers() as $player){
            if($player->getName() === $this->plugin->getKothAPI()->get("capturBy")){
          $player->sendPopup($this->changeBar(self::$number));
            }
          }
          
        }
        if($minutes == 0){
          $this->plugin->getScheduler()->cancelTask($this->getTaskId());
          Core::getInstance()->getServer()->broadcastMessage("§1[§9§l!!!§r§1] §fL'événement Koth viens de ce terminé !");
            $this->plugin->getKothAPI()->stop();
        }

        if($minutes == 5 and($sec == 59)){
            Core::getInstance()->getServer()->broadcastMessage("§1[§9§l!!!§r§1] §fL'événement Koth ce termine dans §c5 minutes §f!");
        }

        if($minutes == 2 and($sec == 59)){
            Core::getInstance()->getServer()->broadcastMessage("§1[§9§l!!!§r§1] §fBonus de Koth §apoint doublé  §f!");
        }

        if($minutes == 10 and($sec == 59)){
            Core::getInstance()->getServer()->broadcastMessage("§1[§9§l!!!§r§1] §fL'événement Koth ce termine dans §c10 minutes §f!");
        }

    }
    
    public function changeBar($number){
      
      return "§9Capture en cours: §1$number%";
    }
}