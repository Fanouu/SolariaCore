<?php

namespace Solaria\Command\Joueur;

use Form\SimpleForm;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\utils\Config;
use Solaria\Core;
use Solaria\Utils\Utils;
use Solaria\API\TagAPI;

class BoutiqueCommand extends Command {
    /** @var Config */
    public static $pb;
    public static $actions = [];
    private $core;

    public function __construct(Core $core) {
        parent::__construct("boutique", "Affiche la boutique du serveur.");
        $this->core = $core;
        $this->moneyAPI = $this->core->getServer()->getPluginManager()->getPlugin("EconomyAPI");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        if ($sender instanceof Player) {
            if(!BoutiqueCommand::$pb->exists($sender->getName())) BoutiqueCommand::$pb->set($sender->getName(), 0);
            BoutiqueCommand::$pb->save();
            $this->BoutiqueForm($sender);


        }else{

            $sender->sendMessage(Utils::getPrefix() . "Utilsez cette command en jeu.");

        }

    }

    public function BoutiqueForm(Player $p){
        $form = new SimpleForm(function (Player $p, $data = null){
            $result = $data;
            if($result == null){
                return true;
            }
            switch ($result){
                case 0:
                    return true;
                case 1:
                    $p->sendMessage("§4§lEn dev");
                    //$this->SpawnerForm($p);
                    break;
                case 2:
                    $this->GradeForm($p);
                    break;
                case 3:
                    $this->KeyForm($p);
                    break;
                case 4:
                    $this->KitsForm($p);
                    break;
                
                case 5:
                    $this->menuTag($p);
                    break;
                    
                case 6:
                  $this->PbForm($p);
                  break;
            }
            return true;
        });
        $form->setTitle("§1§l» §r§9Boutique");
        $form->addButton("§1§l» §r§cFermer");
        $form->addButton("§1§l» §r§9Capes");
        $form->addButton("§1§l» §r§9Grades");
        $form->addButton("§1§l» §r§9Keys");
        $form->addButton("§1§l» §r§9Particule");
        $form->addButton("§1§l» §r§9Tag");
        $form->addButton("§1§l» §r§9Point Boutique §1New");
        $form->sendToPlayer($p);
        return $form;
    }
    public function SpawnerForm(Player $p){
        $form = new SimpleForm(function (Player $p, int $data = null){
            $result = $data;
            if($result == null){
                return true;
            }
            switch ($result){
                case 0:
                    return true;
                case 1:
                    $this->AvantAchatForm($p, Item::get(52, 1, 1), 200, "Spawner a Zombie", 1, "zombie");
                    break;
                case 2:
                    $this->AvantAchatForm($p, Item::get(52, 2, 1), 200, "Spawner a Squelette", 1, "skeleton");
                    break;
                case 3:
                    $this->AvantAchatForm($p, Item::get(52, 3, 1), 350, "Spawner a PigZombie", 1, "zombiepigman");
                    break;
                case 4:
                    $this->AvantAchatForm($p, Item::get(52, 1, 1), 300, "Spawner a Araigné", 1, "spider");
                    break;
            }
            return true;
        });
        $form->setTitle("§9Boutique");
        $form->addButton("§4Fermer");
        $form->addButton("§6> §7Zombie §6<");
        $form->addButton("§6> §7Squelette §6<");
        $form->addButton("§6> §7Cochon Zombie §6<");
        $form->addButton("§6> §7Araigné §6<");
        $form->sendToPlayer($p);
        return true;
    }
    public function GradeForm(Player $p){
        $form = new SimpleForm(function (Player $p, int $data = null){
            $result = $data;
            if($result == null){
                return true;
            }
            switch($result){
                case 0:
                    return true;
                case 1:
                    $this->AvantAchatForm($p, Item::get(0, 0, 0), 500, "grade Vip", 2, "VIP");
                    break;
                case 2:
                    $this->AvantAchatForm($p, Item::get(0, 0, 0), 700, "grade Vip+", 2, "VIPPLUS");
                    break;
                case 3:
                    $this->AvantAchatForm($p, Item::get(0, 0, 0), 1000, "grade Hero", 2, "Hero");
                    break;
                case 4:
                    $this->AvantAchatForm($p, Item::get(0, 0, 0), 1500, "grade Champion", 2, "Champion");
                    break;
                case 5:
                    $this->AvantAchatForm($p, Item::get(0, 0, 0), 2500, "grade Supreme", 2, "Supreme");
                    break;
            }
            return true;
        });
        $form->setTitle("§1§l» §r§9Boutique");
        $form->addButton("§1§l» §r§cFermer");
        $form->addButton("§1§l» §r§fVip");
        $form->addButton("§1§l» §r§fVip+");
        $form->addButton("§1§l» §r§fHero");
        $form->addButton("§1§l» §r§fChampion");
        $form->addButton("§1§l» §r§fSupreme");
        $form->sendToPlayer($p);
    }
    public function KeyForm(Player $p){
        $form = new SimpleForm(function (Player $p, int $data = null){
            $result = $data;
            if($result == null){
                return true;
            }
            switch ($result){
                case 0:
                    return true;
                case 1:
                    $this->AvantAchatForm($p, Item::get(0, 0, 0), 150, "clé rare", 3, "Rare");
                    break;
                case 2:
                    $this->AvantAchatForm($p, Item::get(0, 0, 0), 300, "clé ultime", 3, "Ultime");
                    break;
                case 3:
                    $this->AvantAchatForm($p, Item::get(0, 0, 0), 100, "clé Saphir", 3, "Saphir");
                    break;
                case 4:
                    $this->AvantAchatForm($p, Item::get(0, 0, 0), 500, "clé Boutique", 3, "Boutique");
                    break;
            }
            return true;
        });
        $form->setTitle("§1§l» §r§9Boutique");
        $form->addButton("§1§l» §r§cFermer");
        $form->addButton("§1§l» §r§fRare");
        $form->addButton("§1§l» §r§fUltime");
        $form->addButton("§1§l» §r§fSaphir");
        $form->addButton("§1§l» §r§fBoutique");
        $form->sendToPlayer($p);
    }
    public function KitsForm(Player $p){
        $form = new SimpleForm(function (Player $p, int $data = null){
            $result = $data;
            if($result == null){
                	return true;
            }
            switch ($result){
                case 0:
                    return true;
                case 1:
                    $this->AvantAchatForm($p, Item::get(0, 0, 0), 200, "Fire", 4, "fire");
                    break;
                case 2:
                    $this->AvantAchatForm($p, Item::get(0, 0, 0), 200, "Lava", 4, "lava");
                    break;
                case 3:
                    $this->AvantAchatForm($p, Item::get(0, 0, 0), 200, "Water", 4, "water");
                    break;
                case 4:
                    $this->AvantAchatForm($p, Item::get(0, 0, 0), 200, "Redstone", 4, "redstone");
                    break;
            }
            return true;
        });
        $form->setTitle("§1§l» §r§9Boutique");
        $form->addButton("§1§l» §r§cFermer");
        $form->addButton("§1§l» §r§fFire");
        $form->addButton("§1§l» §r§fLava");
        $form->addButton("§1§l» §r§fWater");
        $form->addButton("§1§l» §r§fRedstone");
        $form->sendToPlayer($p);
    }

    public function AvantAchatForm(Player $p, Item $index, $prix, $Customname, $info, $type = false){
        $this->index[$p->getName()] = $index;
        $this->prix[$p->getName()] = $prix;
        $this->Customname[$p->getName()] = $Customname;
        $this->info[$p->getName()] = $info;
        $this->type[$p->getName()] = $type;
        $form = new SimpleForm(function (Player $p, $data = null){
            $result = $data;
            if($result == null){
                	return true;
            }
            switch($result){
                case 0:
                    unset($this->index[$p->getName()]);
                    unset($this->prix[$p->getName()]);
                    unset($this->Customname[$p->getName()]);
                    break;
                case 1:
                    if(self::$pb->get($p->getName()) - $this->prix[$p->getName()] >= 0) {
                        if ($this->info[$p->getName()] == 1) {
                            Core::getInstance()->getServer()->dispatchCommand(new ConsoleCommandSender(), "spawner {$this->type[$p->getName()]} 1 \"{$p->getName()}\"");
                            $p->sendMessage("§l§1» §r§9Tu as bien acheté un spawner");
                        }
                        if ($this->info[$p->getName()] == 2) {
                            Core::getInstance()->getServer()->dispatchCommand(new ConsoleCommandSender(), "setrank \"{$p->getName()}\" {$this->type[$p->getName()]}");
                            $p->sendMessage("§1§l» §r§9Tu as bien acheté un grade");
                        }
                        if($this->info[$p->getName()] == 3){
                            Core::getInstance()->getServer()->dispatchCommand(new ConsoleCommandSender(), "key {$this->type[$p->getName()]} 1 \"{$p->getName()}\"");
                            $p->sendMessage("§l§1» §r§9Tu as bien acheté une key");
                        }
                        if($this->info[$p->getName()] == 4){
                            Core::getInstance()->getServer()->dispatchCommand(new ConsoleCommandSender(), "setuperm \"{$p->getName()}\" particle.{$this->type[$p->getName()]}");
                            $p->sendMessage("§1§l» §r§9Tu as bien acheté des particules");
                        }
                        
                        if($this->info[$p->getName()] == 5){
                            $tagApi = new TagAPI();
                            $tagApi->addTag($p, $this->type[$p->getName()]);
                            $p->sendMessage("§1§l» §r§9Tu as bien acheté le tag §r§f#{$this->type[$p->getName()]} §r§9!");
                        }
                        self::$pb->set($p->getName(), self::$pb->get($p->getName()) - $this->prix[$p->getName()]);
                        self::$pb->save();
                    }else{
                        $p->sendMessage("§l§1» §r§9Tu n'as pas assez de points boutiques");
                    }
                    break;
            }
            return true;
        });
        $form->setTitle("§l§1» §9Confirmation d'achat");
        $form->setContent("§9Veux tu acheter un §1$Customname §r§9pour §1$prix §9Point Boutique ?");
        $form->addButton("§4» Non");
        $form->addButton("§a» Oui");
        $form->sendToPlayer($p);
        return $form;
    }
    
    public function menuTag(Player $player){
        $form = new SimpleForm(function(Player $player, int $data = null){
            $result = $data;
            if($result === null){
                return true;
            }
            
            $this->AvantAchatForm($player, Item::get(0, 0, 0), 100, "Tag §r§f#".self::$actions[$data], 5, self::$actions[$data]);
        });
        $form->setTitle("§1§l» §r§9Shop Tag");
        $form->setContent("§l§f» §r§9Bienvenue sur le shop des §1Tag");
        $tagsList = ["§6Solaria", "§1Fr§fan§cce", "§cCa§fna§cda", "§2Algé§fria", "§cR§6a§ei§2n§bb§5o§9w", "§cYou§fTube", "§5Steamer", "§8Master§fClass", "§2§kCC§r§fCheater§2§kCC§r", "§cMoro§2co", "§9Pay§fPal", "§5Donateur", "§fTik§0Tok", "§2AutoClicker", "§bW10", "§dFamous", "§2Random", "§cStonk", "§4Pvp", "§2Por§etu§cgal"];
        $i = 0;
        foreach($tagsList as $tag){
            $form->addButton("§l» §r§f#$tag");
            self::$actions[$i] = $tag;
            $i++;
        }
        $form->sendToPlayer($player);
    }
    
    public function PbForm(Player $p){
        $form = new SimpleForm(function (Player $p, int $data = null){
            $result = $data;
            if($result == null){
                	return true;
            }
            switch ($result){
                case 0:
                    return true;
                case 1:
                    $ourmoney = $this->moneyAPI->myMoney($p);
                    if($ourmoney >= 5000){
                      self::$pb->set($p->getName(), 
                      self::$pb->get($p->getName()) + 100);
                      $this->moneyAPI->reduceMoney($p, 5000);
                      $p->sendMessage("§l§1» §r§fTu à bien acheté §9100PB §fpour §95000$");
                    }else{
                      $p->sendMessage("§l§1» §r§fTu n'a pas assez de money !");
                    }
                    break;
                case 2:
                    $ourmoney = $this->moneyAPI->myMoney($p);
                    if($ourmoney >= 25000){
                      self::$pb->set($p->getName(), self::$pb->get($p->getName()) + 500);
                      $this->moneyAPI->reduceMoney($p, 25000);
                      $p->sendMessage("§l§1» §r§fTu à bien acheté §9500PB §fpour §925000$");
                    }else{
                      $p->sendMessage("§l§1» §r§fTu n'a pas assez de money !");
                    }
                    break;
                case 3:
                    $ourmoney = $this->moneyAPI->myMoney($p);
                    if($ourmoney >= 50000){
                      self::$pb->set($p->getName(), self::$pb->get($p->getName()) + 1000);
                      $this->moneyAPI->reduceMoney($p, 50000);
                      $p->sendMessage("§l§1» §r§fTu à bien acheté §91000PB §fpour §950000$");
                    }else{
                      $p->sendMessage("§l§1» §r§fTu n'a pas assez de money !");
                    }
                    break;
            }
            return true;
        });
        $form->setTitle("§1§l» §r§9Boutique");
        $form->addButton("§1§l» §r§cFermer");
        $form->addButton("§1§l» §r§f100PB - §95000$");
        $form->addButton("§1§l» §r§f500 - §925000$");
        $form->addButton("§1§l» §r§f1000 - §950000$");
        $form->sendToPlayer($p);
    }
}