<?php

namespace Solaria\API;

use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\Player;
use Solaria\Utils\Utils;

class KitAPI {

    public static function addKitJoueur(Player $sender) {

        $casque = Item::get(310);
        $plastron = Item::get(311);
        $jambiere = Item::get(312);
        $botte = Item::get(313);
        $epee = Item::get(276);
        $pearl = Item::get(368, 0, 8);
        $force = Item::get(373, 32);
        $speed = Item::get(373, 15);
        $heal = Item::get(438, 22);

        $protection1 = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 1);
        $tranchant1 = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::SHARPNESS), 1);


        $casque->addEnchantment($protection1);
        $plastron->addEnchantment($protection1);
        $botte->addEnchantment($protection1);
        $epee->addEnchantment($tranchant1);


        $sender->getArmorInventory()->setItem(0, $casque);
        $sender->getArmorInventory()->setItem(1, $plastron);
        $sender->getArmorInventory()->setItem(2, $jambiere);
        $sender->getArmorInventory()->setItem(3, $botte);
        $sender->getInventory()->setItem(0, $epee);
        $sender->getInventory()->setItem(1, $pearl);
        $sender->getInventory()->setItem(2, $force);
        $sender->getInventory()->setItem(3, $speed);
        $sender->getInventory()->setItem(4, $heal);
        $sender->getInventory()->setItem(5, $heal);
        $sender->getInventory()->setItem(6, $heal);
        $sender->getInventory()->setItem(7, $heal);
        $sender->getInventory()->setItem(8, $heal);
        $sender->getInventory()->setItem(9, $heal);
        $sender->getInventory()->setItem(10, $heal);
        $sender->getInventory()->setItem(11, $heal);
        $sender->getInventory()->setItem(12, $heal);
        $sender->getInventory()->setItem(13, $heal);
        $sender->getInventory()->setItem(14, $heal);
        $sender->getInventory()->setItem(15, $heal);
        $sender->getInventory()->setItem(16, $heal);
        $sender->getInventory()->setItem(17, $heal);
        $sender->getInventory()->setItem(18, $heal);
        $sender->getInventory()->setItem(19, $heal);
        $sender->getInventory()->setItem(20, $heal);
        $sender->getInventory()->setItem(21, $heal);
        $sender->getInventory()->setItem(22, $heal);
        $sender->getInventory()->setItem(23, $heal);
        $sender->getInventory()->setItem(24, $heal);
        $sender->getInventory()->setItem(25, $heal);
        $sender->getInventory()->setItem(26, $heal);
        $sender->getInventory()->setItem(27, $heal);
        $sender->getInventory()->setItem(28, $heal);
        $sender->getInventory()->setItem(29, $heal);
        $sender->getInventory()->setItem(30, $heal);
        $sender->getInventory()->setItem(31, $heal);
        $sender->getInventory()->setItem(32, $heal);
        $sender->getInventory()->setItem(33, $heal);
        $sender->getInventory()->setItem(34, $heal);
        $sender->getInventory()->setItem(35, $heal);

        $sender->sendMessage(Utils::getPrefix() . "Vous avez reçu votre Kit Joueur.");

    }

    public static function addKitVIP(Player $sender) {

        $casque = Item::get(310);
        $plastron = Item::get(311);
        $jambiere = Item::get(312);
        $botte = Item::get(313);
        $epee = Item::get(276);
        $pearl = Item::get(368, 0, 8);
        $force = Item::get(373, 32);
        $speed = Item::get(373, 15);
        $heal = Item::get(438, 22);

        $protection2 = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 2);
        $protection1 = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 1);
        $tranchant2 = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::SHARPNESS), 2);


        $casque->addEnchantment($protection2);
        $plastron->addEnchantment($protection2);
        $jambiere->addEnchantment($protection1);
        $botte->addEnchantment($protection2);
        $epee->addEnchantment($tranchant2);


        $sender->getArmorInventory()->setItem(0, $casque);
        $sender->getArmorInventory()->setItem(1, $plastron);
        $sender->getArmorInventory()->setItem(2, $jambiere);
        $sender->getArmorInventory()->setItem(3, $botte);
        $sender->getInventory()->setItem(0, $epee);
        $sender->getInventory()->setItem(1, $pearl);
        $sender->getInventory()->setItem(2, $force);
        $sender->getInventory()->setItem(3, $speed);
        $sender->getInventory()->setItem(4, $heal);
        $sender->getInventory()->setItem(5, $heal);
        $sender->getInventory()->setItem(6, $heal);
        $sender->getInventory()->setItem(7, $heal);
        $sender->getInventory()->setItem(8, $heal);
        $sender->getInventory()->setItem(9, $heal);
        $sender->getInventory()->setItem(10, $heal);
        $sender->getInventory()->setItem(11, $heal);
        $sender->getInventory()->setItem(12, $heal);
        $sender->getInventory()->setItem(13, $heal);
        $sender->getInventory()->setItem(14, $heal);
        $sender->getInventory()->setItem(15, $heal);
        $sender->getInventory()->setItem(16, $heal);
        $sender->getInventory()->setItem(17, $heal);
        $sender->getInventory()->setItem(18, $heal);
        $sender->getInventory()->setItem(19, $heal);
        $sender->getInventory()->setItem(20, $heal);
        $sender->getInventory()->setItem(21, $heal);
        $sender->getInventory()->setItem(22, $heal);
        $sender->getInventory()->setItem(23, $heal);
        $sender->getInventory()->setItem(24, $heal);
        $sender->getInventory()->setItem(25, $heal);
        $sender->getInventory()->setItem(26, $heal);
        $sender->getInventory()->setItem(27, $heal);
        $sender->getInventory()->setItem(28, $heal);
        $sender->getInventory()->setItem(29, $heal);
        $sender->getInventory()->setItem(30, $heal);
        $sender->getInventory()->setItem(31, $heal);
        $sender->getInventory()->setItem(32, $heal);
        $sender->getInventory()->setItem(33, $heal);
        $sender->getInventory()->setItem(34, $heal);
        $sender->getInventory()->setItem(35, $heal);

        $sender->sendMessage(Utils::getPrefix() . "Vous avez reçu votre Kit §eVIP§7.");

    }
    public static function addKitVIPPlus (Player $sender) {

        $casque = Item::get(310);
        $plastron = Item::get(311);
        $jambiere = Item::get(312);
        $botte = Item::get(313);
        $epee = Item::get(276);
        $pearl = Item::get(368, 0, 16);
        $force = Item::get(373, 32);
        $speed = Item::get(373, 15);
        $heal = Item::get(438, 22);

        $protection3 = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 3);
        $tranchant3 = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::SHARPNESS), 3);


        $casque->addEnchantment($protection3);
        $plastron->addEnchantment($protection3);
        $jambiere->addEnchantment($protection3);
        $botte->addEnchantment($protection3);
        $epee->addEnchantment($tranchant3);


        $sender->getArmorInventory()->setItem(0, $casque);
        $sender->getArmorInventory()->setItem(1, $plastron);
        $sender->getArmorInventory()->setItem(2, $jambiere);
        $sender->getArmorInventory()->setItem(3, $botte);
        $sender->getInventory()->setItem(0, $epee);
        $sender->getInventory()->setItem(1, $pearl);
        $sender->getInventory()->setItem(2, $force);
        $sender->getInventory()->setItem(3, $speed);
        $sender->getInventory()->setItem(4, $heal);
        $sender->getInventory()->setItem(5, $heal);
        $sender->getInventory()->setItem(6, $heal);
        $sender->getInventory()->setItem(7, $heal);
        $sender->getInventory()->setItem(8, $heal);
        $sender->getInventory()->setItem(9, $heal);
        $sender->getInventory()->setItem(10, $heal);
        $sender->getInventory()->setItem(11, $heal);
        $sender->getInventory()->setItem(12, $heal);
        $sender->getInventory()->setItem(13, $heal);
        $sender->getInventory()->setItem(14, $heal);
        $sender->getInventory()->setItem(15, $heal);
        $sender->getInventory()->setItem(16, $heal);
        $sender->getInventory()->setItem(17, $heal);
        $sender->getInventory()->setItem(18, $heal);
        $sender->getInventory()->setItem(19, $heal);
        $sender->getInventory()->setItem(20, $heal);
        $sender->getInventory()->setItem(21, $heal);
        $sender->getInventory()->setItem(22, $heal);
        $sender->getInventory()->setItem(23, $heal);
        $sender->getInventory()->setItem(24, $heal);
        $sender->getInventory()->setItem(25, $heal);
        $sender->getInventory()->setItem(26, $heal);
        $sender->getInventory()->setItem(27, $heal);
        $sender->getInventory()->setItem(28, $heal);
        $sender->getInventory()->setItem(29, $heal);
        $sender->getInventory()->setItem(30, $heal);
        $sender->getInventory()->setItem(31, $heal);
        $sender->getInventory()->setItem(32, $heal);
        $sender->getInventory()->setItem(33, $heal);
        $sender->getInventory()->setItem(34, $heal);
        $sender->getInventory()->setItem(35, $heal);

        $sender->sendMessage(Utils::getPrefix() . "Vous avez reçu votre Kit §eVIP+§7.");

    }

    public static function addKitHero(Player $sender) {

        $casque = Item::get(310);
        $plastron = Item::get(311);
        $jambiere = Item::get(312);
        $botte = Item::get(313);
        $epee = Item::get(276);
        $pearl = Item::get(368, 0, 16);
        $force = Item::get(373, 32);
        $speed = Item::get(373, 15);
        $heal = Item::get(438, 22);

        $protection3 = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 4);
        $tranchant3 = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::SHARPNESS), 4);


        $casque->addEnchantment($protection3);
        $plastron->addEnchantment($protection3);
        $jambiere->addEnchantment($protection3);
        $botte->addEnchantment($protection3);
        $epee->addEnchantment($tranchant3);


        $sender->getArmorInventory()->setItem(0, $casque);
        $sender->getArmorInventory()->setItem(1, $plastron);
        $sender->getArmorInventory()->setItem(2, $jambiere);
        $sender->getArmorInventory()->setItem(3, $botte);
        $sender->getInventory()->setItem(0, $epee);
        $sender->getInventory()->setItem(1, $pearl);
        $sender->getInventory()->setItem(2, $force);
        $sender->getInventory()->setItem(3, $speed);
        $sender->getInventory()->setItem(4, $heal);
        $sender->getInventory()->setItem(5, $heal);
        $sender->getInventory()->setItem(6, $heal);
        $sender->getInventory()->setItem(7, $heal);
        $sender->getInventory()->setItem(8, $heal);
        $sender->getInventory()->setItem(9, $heal);
        $sender->getInventory()->setItem(10, $heal);
        $sender->getInventory()->setItem(11, $heal);
        $sender->getInventory()->setItem(12, $heal);
        $sender->getInventory()->setItem(13, $heal);
        $sender->getInventory()->setItem(14, $heal);
        $sender->getInventory()->setItem(15, $heal);
        $sender->getInventory()->setItem(16, $heal);
        $sender->getInventory()->setItem(17, $heal);
        $sender->getInventory()->setItem(18, $heal);
        $sender->getInventory()->setItem(19, $heal);
        $sender->getInventory()->setItem(20, $heal);
        $sender->getInventory()->setItem(21, $heal);
        $sender->getInventory()->setItem(22, $heal);
        $sender->getInventory()->setItem(23, $heal);
        $sender->getInventory()->setItem(24, $heal);
        $sender->getInventory()->setItem(25, $heal);
        $sender->getInventory()->setItem(26, $heal);
        $sender->getInventory()->setItem(27, $heal);
        $sender->getInventory()->setItem(28, $heal);
        $sender->getInventory()->setItem(29, $heal);
        $sender->getInventory()->setItem(30, $heal);
        $sender->getInventory()->setItem(31, $heal);
        $sender->getInventory()->setItem(32, $heal);
        $sender->getInventory()->setItem(33, $heal);
        $sender->getInventory()->setItem(34, $heal);
        $sender->getInventory()->setItem(35, $heal);

        $sender->sendMessage(Utils::getPrefix() . "Vous avez reçu votre Kit §bHéro§7.");

    }

    public static function addKitChampion(Player $sender) {

        $casque = Item::get(310);
        $plastron = Item::get(311);
        $jambiere = Item::get(312);
        $botte = Item::get(313);
        $epee = Item::get(276);
        $pearl = Item::get(368, 0, 16);
        $force = Item::get(373, 32);
        $speed = Item::get(373, 15);
        $heal = Item::get(438, 22);

        $protection3 = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 5);
        $tranchant3 = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::SHARPNESS), 5);


        $casque->addEnchantment($protection3);
        $plastron->addEnchantment($protection3);
        $jambiere->addEnchantment($protection3);
        $botte->addEnchantment($protection3);
        $epee->addEnchantment($tranchant3);


        $sender->getArmorInventory()->setItem(0, $casque);
        $sender->getArmorInventory()->setItem(1, $plastron);
        $sender->getArmorInventory()->setItem(2, $jambiere);
        $sender->getArmorInventory()->setItem(3, $botte);
        $sender->getInventory()->setItem(0, $epee);
        $sender->getInventory()->setItem(1, $pearl);
        $sender->getInventory()->setItem(2, $force);
        $sender->getInventory()->setItem(3, $speed);
        $sender->getInventory()->setItem(4, $heal);
        $sender->getInventory()->setItem(5, $heal);
        $sender->getInventory()->setItem(6, $heal);
        $sender->getInventory()->setItem(7, $heal);
        $sender->getInventory()->setItem(8, $heal);
        $sender->getInventory()->setItem(9, $heal);
        $sender->getInventory()->setItem(10, $heal);
        $sender->getInventory()->setItem(11, $heal);
        $sender->getInventory()->setItem(12, $heal);
        $sender->getInventory()->setItem(13, $heal);
        $sender->getInventory()->setItem(14, $heal);
        $sender->getInventory()->setItem(15, $heal);
        $sender->getInventory()->setItem(16, $heal);
        $sender->getInventory()->setItem(17, $heal);
        $sender->getInventory()->setItem(18, $heal);
        $sender->getInventory()->setItem(19, $heal);
        $sender->getInventory()->setItem(20, $heal);
        $sender->getInventory()->setItem(21, $heal);
        $sender->getInventory()->setItem(22, $heal);
        $sender->getInventory()->setItem(23, $heal);
        $sender->getInventory()->setItem(24, $heal);
        $sender->getInventory()->setItem(25, $heal);
        $sender->getInventory()->setItem(26, $heal);
        $sender->getInventory()->setItem(27, $heal);
        $sender->getInventory()->setItem(28, $heal);
        $sender->getInventory()->setItem(29, $heal);
        $sender->getInventory()->setItem(30, $heal);
        $sender->getInventory()->setItem(31, $heal);
        $sender->getInventory()->setItem(32, $heal);
        $sender->getInventory()->setItem(33, $heal);
        $sender->getInventory()->setItem(34, $heal);
        $sender->getInventory()->setItem(35, $heal);

        $sender->sendMessage(Utils::getPrefix() . "Vous avez reçu votre Kit §6Champion§7.");

    }

    public static function addKitTools(Player $sender) {

        $pioche = Item::get(278);
        $hache = Item::get(279);
        $pelle = Item::get(277);

        $efficacite5 = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::EFFICIENCY), 5);
        $solidite3 = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3);

        $pioche->addEnchantment($efficacite5);
        $pioche->addEnchantment($solidite3);

        $hache->addEnchantment($efficacite5);
        $hache->addEnchantment($solidite3);

        $pelle->addEnchantment($efficacite5);
        $pelle->addEnchantment($solidite3);


        $sender->getInventory()->setItem(0, $pioche);
        $sender->getInventory()->setItem(1, $hache);
        $sender->getInventory()->setItem(2, $pelle);

        $sender->sendMessage(Utils::getPrefix() . "Vous avez reçu le kit §8Tools§7.");

    }

    public static function addKitHeal(Player $sender) {

        $heal = Item::get(438, 22, 3);

        $sender->getInventory()->addItem($heal);

        $sender->sendMessage(Utils::getPrefix() . "Vous avez reçu le kit §dHeal§7.");

    }
    public static function addKitBuilder(Player $sender){
        $dirt = Item::get(3, 0, 64);
        $herbe = Item::get(2, 0, 64);
        $pierrechelou = Item::get(98, 0, 64);
        $troncarbre = Item::get(17, 0, 64);
        $quartz = Item::get(155, 0, 64);
        $end = Item::get(206, 0, 64);
        $stone = Item::get(4, 0, 64);
        $trucrouge = Item::get(179, 0, 64);
        $sable = Item::get(12, 0, 64);
        $pierre = Item::get(1, 0, 64);
        $four = Item::get(61, 0, 64);
        $coffre = Item::get(54, 0, 64);
        $verre = Item::get(20, 0, 64);
        $planche = Item::get(5, 0, 64);
        
        $e = new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3);
        
        $ferh = Item::get(306, 0, 1);
        $ferc = Item::get(307, 0, 1);
        $ferl = Item::get(308, 0, 1);
        $ferb = Item::get(309, 0, 1);
        
        $pelle = Item::get(256, 0, 1);
        $hache = Item::get(257, 0, 1);
        $epee = Item::get(258, 0, 1);
        
        $pelle->addEnchantment($e);
        $hache->addEnchantment($e);
        $epee->addEnchantment($e);
        
        $ferh->addEnchantment($e);
        $ferc->addEnchantment($e);
        $ferl->addEnchantment($e);
        $ferb->addEnchantment($e);
        
        $sender->getInventory()->setItem(0, $herbe);
        $sender->getInventory()->setItem(1, $dirt);
        $sender->getInventory()->setItem(2, $pierrechelou);
        $sender->getInventory()->setItem(3, $pierrechelou);
        $sender->getInventory()->setItem(4, $troncarbre);
        $sender->getInventory()->setItem(5, $troncarbre);
        $sender->getInventory()->setItem(6, $quartz);
        $sender->getInventory()->setItem(7, $end);
        $sender->getInventory()->setItem(8, $end);
        $sender->getInventory()->setItem(9, $herbe);
        $sender->getInventory()->setItem(10, $stone);
        $sender->getInventory()->setItem(11, $stone);
        $sender->getInventory()->setItem(12, $trucrouge);
        $sender->getInventory()->setItem(13, $trucrouge);
        $sender->getInventory()->setItem(14, $herbe);
        $sender->getInventory()->setItem(15, $sable);
        $sender->getInventory()->setItem(16, $sable);
        $sender->getInventory()->setItem(17, $dirt);
        $sender->getInventory()->setItem(18, $pierre);
        $sender->getInventory()->setItem(19, $four);
        $sender->getInventory()->setItem(20, $pierre);
        $sender->getInventory()->setItem(21, $coffre);
        $sender->getInventory()->setItem(22, $quartz);
        $sender->getInventory()->setItem(23, $verre);
        $sender->getInventory()->setItem(24, $planche);
        $sender->getInventory()->setItem(25, $planche);
        $sender->getInventory()->setItem(26, $troncarbre);
        $sender->getInventory()->setItem(27, $ferh);
        $sender->getInventory()->setItem(28, $ferc);
        $sender->getInventory()->setItem(29, $ferl);
        $sender->getInventory()->setItem(30, $ferb);
        $sender->getInventory()->setItem(31, $hache);
        $sender->getInventory()->setItem(32, $pelle);
        $sender->getInventory()->setItem(33, $epee);
        
        $sender->sendMessage(Utils::getPrefix() . "Vous avez reçu le kit §6Builder§7.");
        
        
    }

}