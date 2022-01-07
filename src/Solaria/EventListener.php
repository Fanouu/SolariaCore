<?php

namespace Solaria;

use pocketmine\block\Block;
use pocketmine\block\CoalOre;
use pocketmine\entity\Entity;
use pocketmine\entity\EntityIds;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityMotionEvent;
use pocketmine\event\entity\ProjectileHitBlockEvent;
use pocketmine\event\entity\ProjectileHitEntityEvent;
use pocketmine\event\entity\ProjectileHitEvent;
use pocketmine\event\entity\ProjectileLaunchEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerKickEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\item\Egg;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\level\Position;
use pocketmine\level\sound\EndermanTeleportSound;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use Solaria\Command\Staff\BanCommand;
use Solaria\Command\Staff\FreezeCommand;
use Solaria\Command\Staff\MuteCommand;
use Solaria\Tasks\AtmTask;
use Solaria\Utils\AnvilUI;
use Solaria\Utils\Permissions;
use Solaria\Utils\Purif;
use Solaria\Utils\Utils;
use Solaria\Listener\SpawnListener;

class EventListener implements Listener {

    public function onPlayerJoin(PlayerJoinEvent $event)
    {
        $sender = $event->getPlayer();
        $sender->teleport(Core::getInstance()->getServer()->getDefaultLevel()->getSafeSpawn());
        $name = $sender->getDisplayName();
        $rank = Core::getRankAPI()->getRank($sender);
        $nametag = Core::getRankAPI()->getNametag($sender, $rank);
        if (BanCommand::$banlist->get($sender->getName()) == "vie") {
            $sender->kick("§7---------------[§9Bannissement§7]---------------\n §7Tu es banni(e) du serveur définitivement\n §7- Discord: §bhttps://discord.gg/kxBnmFXAWA\n§7---------------------------------------", false);
            $sender->setImmobile(true);
            $event->setJoinMessage("");
        } else {
            if (BanCommand::$banlist->get($sender->getName()) > time()) {
                $sender->kick("§7---------------[§9Bannissement§7]---------------\n §7Tu es banni(e) du serveur temporairement\n §7- Discord: §bhttps://discord.gg/kxBnmFXAWA\n§7---------------------------------------", false);
                $sender->setImmobile(true);
                $event->setJoinMessage("");
            }else{
                if (FreezeCommand::$freeze->get($sender->getName()) == true) {
                    $sender->setImmobile(true);
                    $sender->addTitle("§9Tu est freeze par un §1modérateur");
                    $sender->addSubTitle("§fViens vocal sur le discord");
                } else {
                    if (!$sender->hasPlayedBefore()) {

                        $config = new Config(Core::getInstance()->getDataFolder() . "Player/" . $sender->getName() . ".json", Config::JSON);

                        $config->set("FIRST_CONNEXION", date("d/m/Y à H:i"));
                        $config->save();

                        $event->setJoinMessage("");
                        Core::getInstance()->getServer()->broadcastMessage(Utils::getPrefix() . "§b{$sender->getName()} §7est nouveau sur le serveur.");

                    } else {

                        $rank = Core::getRankAPI()->getRankColored($sender);

                        $event->setJoinMessage("");
                        Core::getInstance()->getServer()->broadcastMessage("§7[§a+§7] [{$rank}§7] {$sender->getName()}");

                    }
                    $sender->setNameTag($nametag);

                }
            }
        }
    }

    public function onPlayerQuit(PlayerQuitEvent $event) {

        $sender = $event->getPlayer();

        $rank = Core::getRankAPI()->getRankColored($sender);

        $event->setQuitMessage("");
        foreach (Server::getInstance()->getOnlinePlayers() as $player){
            $player->sendMessage("§7[§c-§7] [{$rank}§7] {$sender->getName()}");
        }
        
        Purif::disablePurif($event->getPlayer());
        if(isset(SpawnListener::$Players[$sender->getName()])){
            unset(SpawnListener::$Players[$sender->getName()]);
        }
    }

    public function onPrelogin(PlayerPreLoginEvent $event) {

        $player = $event->getPlayer();

        Core::getRankAPI()->existuperm($player);
        if (Core::getRankAPI()->existPlayer($player) == false) {
            Core::getRankAPI()->setDefaultChatConfig($player);
        }
        Core::getRankAPI()->registerPlayer($player);

    }

    public function playerchat(PlayerChatEvent $event) {
        $player = $event->getPlayer();

        $p = $event->getPlayer();
        $c = $event->getMessage();

        $c = explode(" ", $c);
        foreach ($c as $w){
            switch ($w){
                case "Erodia":
                case "erodia":
                case "plutonium":
                case "TopBoy":
                case "topboy":
                    $p->sendMessage(Utils::getPrefix() . "§l§1[§9!!!§1] §r§cles pub de server concurrent ne sont pas autorisés !");
                    $event->setCancelled(true);
                    break;
                case "admins":
                case "admin":
                case "modos":
                case "modo":
                    $p->sendMessage(Utils::getPrefix() . "§1§l[§9!!!§1]§r§f Merci de ne pas dire §
                    §1{$w}§f, Précise nous ton problème !");
                    break;
            }
        }

        $event->setFormat(Core::getRankAPI()->formatMessage($player, $event->getMessage()));

        $config = new Config(Core::getInstance()->getDataFolder() . "Config.json", Config::JSON);
        if(MuteCommand::$mutelist->exists($player->getName())) {
            if (MuteCommand::$mutelist->get($player->getName()) == "vie") {
                $event->setCancelled(true);
                $player->sendMessage(Utils::getPrefix() . "Tu as étais mute, tu ne peux pas parler. (Durée définitive)");
            } elseif (MuteCommand::$mutelist->get($player->getName()) > time()) {
                $event->setCancelled(true);
                $player->sendMessage(Utils::getPrefix() . "Tu as étais mute, tu ne peux pas parler. (Durée temporaire)");
            }
        }
        if ($config->get("MuteChat") === true) {

            if (!$player->hasPermission(Permissions::MUTECHAT)) {

                $event->setCancelled(true);
                $player->sendMessage(Utils::getPrefix() . "Le chat est désactivé.");

            }

        }

    }
    public function onMove(PlayerMoveEvent $e){
        Purif::onZone($e->getPlayer());
        Utils::walk($e->getPlayer());
    }
    public function onHit(ProjectileHitBlockEvent $e){
        $entity = $e->getEntity();
        $name = (new \ReflectionClass($entity))->getShortName();
        if("Egg" == $name){
            $player = $entity->getOwningEntity();
            if($player instanceof Player){
                $player->teleport($e->getBlockHit());
                $player->getLevel()->addSound(new EndermanTeleportSound($player));
            }
        }
    }
    public function onDamage(EntityDamageEvent $e){
        if($e instanceof EntityDamageByEntityEvent){
            $e->setKnockBack(0.4);
        }
    }
}
