<?php


namespace Solaria\Command\Joueur;

use muqsit\invmenu\InvMenu;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\item\Item;
use pocketmine\Player;
use Solaria\API\KitAPI;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class KitCommand extends Command {

    public function __construct() {
        parent::__construct("kit", "Ouvre le menu des kits.");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        if ($sender instanceof Player) {

            $this->menuKit($sender);

        }else{

            $sender->sendMessage(Utils::getPrefix() . "Utilisez cette commande en jeu.");

        }

    }

    public function menuKit($sender) {

        $menu = InvMenu::create(InvMenu::TYPE_CHEST);
        $menu->readonly();
        $menu->setName("             §b[§7Kit Solaria§b]");

        $joueur = Item::get(268);
        $vip = Item::get(272);
        $vipplus = Item::get(267);
        $hero = Item::get(283);
        $champion = Item::get(276);
        $builder = Item::get(2);
        $tools = Item::get(278);
        $potion = Item::get(438, 22);
        $glass = Item::get(160, 15);

        $joueur->setCustomName("§b- §7Kit Joueur §b-");
        $vip->setCustomName("§b- §7Kit §eVIP §b-");
        $vipplus->setCustomName("§b- §7Kit §eVIP§6+ §b-");
        $hero->setCustomName("§b- §7Kit §9Hero §b-");
        $champion->setCustomName("§b- §7Kit §5Champion §7-");
        $builder->setCustomName("§b- §7Kit §6Buildeur §b-");
        $tools->setCustomName("§b- §7Kit §8Tools §b-");
        $potion->setCustomName("§b- §7Kit §5Heal §b-");
        $glass->setCustomName(" ");

        $menu->getInventory()->setItem(0, $glass);
        $menu->getInventory()->setItem(1, $glass);
        $menu->getInventory()->setItem(2, $glass);
        $menu->getInventory()->setItem(3, $glass);
        $menu->getInventory()->setItem(4, $glass);
        $menu->getInventory()->setItem(5, $glass);
        $menu->getInventory()->setItem(6, $glass);
        $menu->getInventory()->setItem(7, $glass);
        $menu->getInventory()->setItem(8, $glass);
        $menu->getInventory()->setItem(9, $glass);
        $menu->getInventory()->setItem(10, $glass);
        $menu->getInventory()->setItem(11, $joueur);
        $menu->getInventory()->setItem(12, $vip);
        $menu->getInventory()->setItem(13, $vipplus);
        $menu->getInventory()->setItem(14, $hero);
        $menu->getInventory()->setItem(15, $champion);
        $menu->getInventory()->setItem(16, $glass);
        $menu->getInventory()->setItem(17, $glass);
        $menu->getInventory()->setItem(18, $glass);
        $menu->getInventory()->setItem(19, $glass);
        $menu->getInventory()->setItem(20, $glass);
        $menu->getInventory()->setItem(21, $tools);
        $menu->getInventory()->setItem(22, $builder);
        $menu->getInventory()->setItem(23, $potion);
        $menu->getInventory()->setItem(24, $glass);
        $menu->getInventory()->setItem(25, $glass);
        $menu->getInventory()->setItem(26, $glass);
        $menu->send($sender);

        $menu->setListener(function (Player $sender, Item $item) {
            switch ($item->getCustomName()) {

                case "§b- §7Kit Joueur §b-":

                    KitAPI::addKitJoueur($sender);
                    break;

                case "§b- §7Kit §eVIP §b-":
                    if (!$sender->hasPermission(Permissions::KIT_VIP)) return $sender->sendMessage(Utils::getPrefix() . "§cVous n'avez pas la permission §ekit.vip §c!");
                    KitAPI::addKitVIP($sender);
                    break;
                case "§b- §7Kit §eVIP§6+ §b-":
                    if (!$sender->hasPermission(Permissions::KIT_VIPPLUS)) return $sender->sendMessage(Utils::getPrefix() . "§cVous n'avez pas la permission §ekit.vipplus §c!");
                    KitAPI::addKitVIPPlus($sender);
                    break;
                case "§b- §7Kit §9Hero §b-":
                    if (!$sender->hasPermission(Permissions::KIT_HERO)) return $sender->sendMessage(Utils::getPrefix() . "§cVous n'avez pas la permission §ekit.hero §c!");
                    KitAPI::addKitHero($sender);
                    break;
                case "§b- §7Kit §5Champion §7-":
                    if (!$sender->hasPermission(Permissions::KIT_CHAMPION)) return $sender->sendMessage(Utils::getPrefix() . "§cVous n'avez pas la permission §ekit.champion §c!");
                    KitAPI::addKitChampion($sender);
                    break;
                case "§b- §7Kit §8Tools §b-":
                    KitAPI::addKitTools($sender);
                    break;
                case "§b- §7Kit §6Buildeur §b-":
                    KitAPI::addKitBuilder($sender);
                    break;
                case "§b- §7Kit §5Heal §b-":
                    if (!$sender->hasPermission(Permissions::KIT_HEAL)) return $sender->sendMessage(Utils::getPrefix() . "§cVous n'avez pas la permission §ekit.heal§c.");
                    KitAPI::addKitHeal($sender);
                    break;
            }

            return true;
        });
    }

}