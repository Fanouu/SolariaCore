<?php

namespace Solaria\Utils;

use Form\SimpleForm;
use onebone\economyapi\EconomyAPI;
use pocketmine\Player;

class AnvilUI{
    public static function interact(Player $p){
        AnvilUI::MenuForm($p);
    }
    public static function MenuForm(Player $p){
        $form = new SimpleForm(function (Player $p, int $data){
            $r = $data;
            if($r == null) return;
            switch ($r){
                case 0:
                    break;
                case 1:
                    if(EconomyAPI::getInstance()->myMoney($p) >= 5) {
                        $p->getInventory()->setItemInHand($p->getInventory()->getItemInHand()->setDamage(0));
                        EconomyAPI::getInstance()->reduceMoney($p, 15);
                        $p->sendMessage(Utils::getPrefix() . "Tu as bien réparé ton item");
                    }else{
                        $p->sendMessage(Utils::getPrefix() . "Tu n'as pas assez d'argent");
                    }
                    break;
            }
        });
        $form->setTitle("§6§l- §fEnclume §6§l-");
        $form->addButton("§c<- FERMER");
        $form->addButton("§6> §fRéparé (15 Jetons) §6<");
        $form->sendToPlayer($p);
        return $form;
    }
}