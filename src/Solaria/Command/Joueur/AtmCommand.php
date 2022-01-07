<?php

namespace Solaria\Command\Joueur;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\utils\Config;
use Solaria\Core;
use Solaria\Tasks\AtmTask;
use Solaria\Utils\Utils;

class AtmCommand extends Command{
    /** @var Config */
    public static $atm;
    public function __construct(){
        parent::__construct("atm", "Permet de récuperer de l'argent en se connectant");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player){
            $p = $sender;
            if(!self::$atm->exists($p->getName())) {
                self::$atm->set($p->getName());
                $p->sendMessage(Utils::getPrefix() . "Ton atm viens de démarrer ! ");
            }else {
                if(self::$atm->get($p->getName()) == 0){
                    $p->sendMessage(Utils::getPrefix() . "Ton atm est vide ! ");
                }else{
                    $c = self::$atm->get($p->getName());
                    $i = Item::get(Item::EMERALD);
                    $p->getInventory()->addItem($i->setCount($c));
                    self::$atm->set($p->getName(), 0);
                    $p->sendMessage(Utils::getPrefix() . "Tu viens de gagner {$c} émeraude(s) !");
                }
            }
            self::$atm->save();
        }
    }
}