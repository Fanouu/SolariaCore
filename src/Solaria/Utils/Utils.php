<?php

namespace Solaria\Utils;

use CortexPE\DiscordWebhookAPI\Embed;
use CortexPE\DiscordWebhookAPI\Message;
use CortexPE\DiscordWebhookAPI\Webhook;
use muqsit\invmenu\InvMenu;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\level\particle\FlameParticle;
use pocketmine\level\particle\HappyVillagerParticle;
use pocketmine\level\particle\LavaParticle;
use pocketmine\level\particle\RedstoneParticle;
use pocketmine\level\particle\WaterParticle;
use pocketmine\Player;
use pocketmine\utils\Config;
use Solaria\Core;
use Solaria\Tasks\PurifTask;

class Utils {

    public const PREFIX = "§l§1[§9Solaria§1]§r§f ";
    public const MINAGE = "§l§1[§9Minage§1]§r§f ";
    /** @var Config */
    public static $walk;

    public static function getPrefix() {

        return self::PREFIX ;

    }
    public static function sendWebHook(string $message = "", string $title = "", string $url = "drop_your_webhook_link") {
        $msg = new Message();
        $webHook = new Webhook($url);
        $embed = new Embed();
        if($title !== "")
            $embed->setTitle($title);
        $embed->setDescription($message);
        $embed->setFooter(date("d/m/Y à H:i"));
        $msg->addEmbed($embed);
        $webHook->send($msg);
    }
    public static function PurifMenu(Player $p){
        $menu = InvMenu::create(InvMenu::TYPE_HOPPER);
        $menu->readonly();
        $menu->setName("             §b[§7Purification§b]");
        $inv = $menu->getInventory();
        $glass = Item::get(160, 15);
        $or = Item::get(ItemIds::GOLD_INGOT);
        $or->setCustomName("§aPurifier");
        $glass->setCustomName(" ");
        $inv->setItem(0, $glass);
        $inv->setItem(1, $glass);
        $inv->setItem(2, $or);
        $inv->setItem(3, $glass);
        $inv->setItem(4, $glass);

        $menu->send($p);

        $menu->setListener(function (Player $p, Item $i){
            switch ($i->getName()){
                case "§aPurifier":
                    Core::getInstance()->getScheduler()->scheduleRepeatingTask(new PurifTask($p), 20);
                    Core::$purif[$p->getName()] = true;
            }
            return true;
        });
    }

    public static function walk(Player $p){
        $c = self::$walk;
        if($c->exists($p->getName()) && !$c->get($p->getName()) === false){
        switch ($c->get($p->getName())){
            case "fire":
                Core::getInstance()->getServer()->getLevel($p->getLevel()->getId())->addParticle(new FlameParticle($p->getPosition()));
                break;
            case "red":
                Core::getInstance()->getServer()->getLevel($p->getLevel()->getId())->addParticle(new RedstoneParticle($p->getPosition()));
                break;
            case "lava":
                Core::getInstance()->getServer()->getLevel($p->getLevel()->getId())->addParticle(new LavaParticle($p->getPosition()));
                break;
            case "happy":
                Core::getInstance()->getServer()->getLevel($p->getLevel()->getId())->addParticle(new HappyVillagerParticle($p->getPosition()));
                break;
            case "water":
                Core::getInstance()->getServer()->getLevel($p->getLevel()->getId())->addParticle(new WaterParticle($p->getPosition()));
            break;
            
            case false:
                return false;
            break;
        }
        }
    }
}
