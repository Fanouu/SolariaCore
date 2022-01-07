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
use Solaria\API\TagAPI;
use Solaria\Tasks\AtoutTask;
use pocketmine\level\Position;
use pocketmine\utils\Config;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use Form\CustomForm;

class CosmeticCommand extends Command {

  private $plugin;
  public static $atoutPlayers = [];

    public function __construct(Core $plugin) {
        parent::__construct("cosmetic", "Ouvre le menu des cosmetic.");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        if ($sender instanceof Player) {

            $this->menuCosmetic($sender);

        }else{

            $sender->sendMessage(Utils::getPrefix() . "Utilisez cette commande en jeu.");

        }

    }
    
    public function menuCosmetic(Player $player){
    $form = self::createSimpleForm(function (Player $player, int $data = null){
      $result = $data;
      if($result === null){
          return true;
      }
      switch($result){
          case 0:
              $player->getServer()->dispatchCommand($player, "cape");
          break;
              
          case 1:
              $this->menuAtout($player);
          break;
              
          case 2:
              $this->menuTag($player);
          break;
          
          case 3:
              $player->getServer()->dispatchCommand($player, "particle");
          break;
      }
      return true;

    });
    $form->setTitle("§l§9Solaria §1Cosmetic");
    $form->addButton("§l» §r§9Cape", 0, "textures/items/emerald");
    $form->addButton("§l» §r§9Atout", 0, "textures/items/feather");
    $form->addButton("§l» §r§9Tag", 0, "textures/items/name_tag");
    $form->addButton("§l» §r§9Particule", 0, "textures/items/iron_sword");
    $form->addButton("§l» §r§9Pass de Combat §1Bientot", 0, "textures/items/gold_axe");
    $player->sendForm($form);
  }
    
    public function menuAtout(Player $player){
        $form = self::createSimpleForm(function (Player $player, int $data = null){
            $result = $data;
            if($result === null){
                $this->menuCosmetic($player);
                return true;
            }
            
            switch($result){
                case 0:
                    if($player->hasPermission("speed.atout.solaria")){
                        if(!isset(self::$atoutPlayers[$player->getName()."_speed"])){
                            $player->addEffect(new EffectInstance(Effect::getEffect(Effect::SPEED), 10*10000, 0));
                            self::$atoutPlayers[$player->getName()."_speed"] = true;
                            $player->sendMessage("§l§1[§9!!!§1] §r§fAtout activé avec succès !");
                        }else{
                            $player->removeEffect(Effect::SPEED);
                            unset(self::$atoutPlayers[$player->getName()."_speed"]);
                            $player->sendMessage("§l§1[§9!!!§1] §r§fAtout désactivé veillez attendre quelque seconde pour le retrait des effets !");
                        }
                    }else{
                        $player->sendMessage("§l» §r§9Vous n'avez pas les permission requise !");
                    }
                break;
                    
                case 1:
                    if($player->hasPermission("jump.atout.solaria")){
                        if(!isset(self::$atoutPlayers[$player->getName()."_jump"])){
                            $player->addEffect(new EffectInstance(Effect::getEffect(Effect::JUMP_BOOST), 10*10000, 0));
                            self::$atoutPlayers[$player->getName()."_jump"] = true;
                            $player->sendMessage("§1§l[§9!!!§1]§r§f Atout activé avec succès !");
                        }else{
                            $player->removeEffect(Effect::JUMP_BOOST);
                            unset(self::$atoutPlayers[$player->getName()."_jump"]);
                            $player->sendMessage("§1§l[§9!!!§1] §r§fAtout désactivé veillez attendre quelque seconde pour le retrait des effets !");
                        }
                    }else{
                        $player->sendMessage("§l» §r§9Vous n'avez pas les permission requise !");
                    }
                break;
                
                case 2:
                    if($player->hasPermission("force.atout.solaria")){
                        if(!isset(self::$atoutPlayers[$player->getName()."_force"])){
                            $player->addEffect(new EffectInstance(Effect::getEffect(Effect::STRENGTH), 10*10000, 0));
                            self::$atoutPlayers[$player->getName()."_force"] = true;
                            $player->sendMessage("§l§1[§9!!!§1] §r§fAtout activé avec succès !");
                        }else{
                            $player->removeEffect(Effect::STRENGTH);
                            unset(self::$atoutPlayers[$player->getName()."_force"]);
                            $player->sendMessage("§l§1[§9!!!§1] §r§fAtout désactivé veillez attendre quelque seconde avant le retrait des effets !");
                        }
                    }else{
                        $player->sendMessage("§l» §r§9Vous n'avez pas les permission requise !");
                    }
                break;
                    
                case 3:
                    $this->menuCosmetic($player);
                break;
            }     
        });       
        $form->setTitle("§9§lSolaria §1Cosmetic");
        $form->addButton("§l»§r§9 Speed I", 0, "textures/items/feather");
        $form->addButton("§l»§r§9 Jump Boost I", 0, "textures/items/iron_boots");
        $form->addButton("§l»§r§9 Force I", 0, "textures/items/diamond_sword");
        $form->addButton("§l»§r§1Retour", 0, "textures/blocks/barrier");
        $player->sendForm($form);
    }
    
    public function menuTag(Player $player){
        $form = self::createCustomForm(function(Player $player, array $data = null){
            if($data === null){
                $this->menuCosmetic($player);
            }else{
                $tagApi = new TagAPI();
                if($tagApi->getTags($player) !== null){
                $selected_tag = $this->playerTag($player)[$data[0]];
                $tagApi->setTag($player, $selected_tag);
                $player->sendMessage("§l§1» §r§9Vous avez bien set votre tag sur §r§f#$selected_tag §r§9!");
                }
            }
        });
        $form->setTitle("§9§lSolaria §1Cosmetic");
        $form->addDropdown("§9Liste de vos §1Tag", $this->playerTag($player));
        $form->sendToPlayer($player);
    }
  
    public function playerTag($player){
        $tagAPI = new TagAPI();
        $tag = $tagAPI->getTags($player);
        
        if($tag === null){
            return [];
        }else{
            return $tag;
        }
    }
  
  public static function createSimpleForm(callable $function = null) : SimpleForm {
    return new SimpleForm($function);
  }
    
  public static function createCustomForm(callable $function = null) : CustomForm{
      return new CustomForm($function);
  }
}