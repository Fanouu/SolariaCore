<?php


namespace Solaria\Command\Joueur;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\Player;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;
use Form\SimpleForm;
use Solaria\Core;
use pocketmine\level\Position;
use pocketmine\utils\Config;

class EventCommand extends Command {

  private $plugin;

    public function __construct(Core $plugin) {
        parent::__construct("event", "Ouvre le menu des event.");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        if ($sender instanceof Player) {

            $this->menuEvent($sender);

        }else{

            $sender->sendMessage(Utils::getPrefix() . "Utilisez cette commande en jeu.");

        }

    }
    
    public function menuEvent(Player $player){
    $form = self::createSimpleForm(function (Player $player, int $data = null){
      $result = $data;
      if($result === null){
          return true;
      }
      switch($result){
          case 0:
            $cfg = new Config($this->plugin->getDataFolder() . "Config.yml", Config::YAML);
      $pos = explode(":", $cfg->get("TpKothPos"));
            $player->teleport(new Position(100, 73, -1, $this->plugin->getServer()->getLevelByName("kitmap")));
          break;
          
          case 1:
          break;
              
          case 2:
          break;
              
          case 3:
              $player->teleport(new Position(100, 73, -1, $this->plugin->getServer()->getLevelByName("kitmap")));
          break;
      }
      return true;

    });
    $form->setTitle("§l§9Solaria §1Event");
    $form->addButton("§l» §r§9Koth \n" . $this->plugin->getKothAPI()->getKothEnable(), 0, "textures/items/emerald");
    $form->addButton("§1§l» §r§eTotem", 0, "textures/items/totem");
    $form->addButton("§l§1» §r§5Nexus", 0, "textures/items/end_crystal");
    $form->addButton("§l§1» §r§7Boss", 0, "textures/items/egg");
    $player->sendForm($form);
  }
  
  public static function createSimpleForm(callable $function = null) : SimpleForm {
    return new SimpleForm($function);
  }
}