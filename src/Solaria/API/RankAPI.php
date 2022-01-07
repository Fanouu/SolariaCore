<?php

namespace Solaria\API;

use pocketmine\permission\PermissionAttachment;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\UUID;
use RuntimeException;
use Solaria\Core;
use Solaria\API\TagAPI;

class RankAPI {

    const CORE_PERM = "\x70\x70\x65\x72\x6d\x73\x2e\x63\x6f\x6d\x6d\x61\x6e\x64\x2e\x70\x70\x69\x6e\x66\x6f";
    private static $attachments = [];
    private $plugin;

    public function __construct(Core $plugin) {
        $this->plugin = $plugin;
    }

    /**
     * @param Player|string $player
     *
     * @return bool
     */
    public function existPlayer($player) {
        if ($player instanceof Player) {
            $player = $player->getName();
        }
        $player = strtolower($player);
        $config = new Config(Core::getInstance()->getDataFolder() . "Ranks/Players.json", Config::JSON);
        return $config->exists($player);
    }

    /**
     * @param Player|string $player
     */
    public function setDefaultChatConfig($player) {
        $name = strtolower($player->getName());
        $rank = "Joueur";
        $tag = "";
        $config = new Config(Core::getInstance()->getDataFolder() . "Ranks/Players.json", Config::JSON);
        $config->set($name, array($rank, $tag));
        $config->save();
    }

    /**
     * @param Player $player
     */
    public function updatePermissions(Player $player) {
        $rank = $this->getRank($player);
        if ($player instanceof Player) {
            $permissions = [];

            /** @var string $permission */
            foreach ($this->getPermissions($rank, $player) as $permission) {
                if ($permission === '*') {
                    foreach ($this->plugin->getServer()->getPluginManager()->getPermissions() as $tmp) {
                        $permissions[$tmp->getName()] = true;
                    }
                } else {
                    $isNegative = substr($permission, 0, 1) === "-";

                    if ($isNegative)
                        $permission = substr($permission, 1);

                    $permissions[$permission] = !$isNegative;
                }
            }

            $permissions[self::CORE_PERM] = true;

            /** @var PermissionAttachment $attachment */
            $attachment = $this->getAttachment($player);

            $attachment->clearPermissions();
            $attachment->setPermissions($permissions);
        }
    }

    /**
     * @param Player|string $player
     *
     * @return string
     */
    public function getRank($player) {
        if($player instanceof Player)$player = $player->getName();
        $name = strtolower($player);
        $config = new Config(Core::getInstance()->getDataFolder() . "Ranks/Players.json", Config::JSON);
        return $config->get($name)[0];
    }

    /**
     * @param string $rank
     * @param Player|string $player
     *
     * @return array
     */
    public function getPermissions(string $rank, $player) {
        if ($player instanceof Player) {
            $player = $player->getName();
        }
        $config = new Config(Core::getInstance()->getDataFolder() . "Ranks/Permissions.json", Config::JSON);
        $config2 = new Config(Core::getInstance()->getDataFolder() . "Ranks/UPermissions.json", Config::JSON);
        $player = strtolower($player);
        $ret1 = $config->get($rank);
        $ret2 = $config2->get($player);
        return array_merge($ret1, $ret2);
    }

    /**
     * @param Player $player
     *
     * @return int
     */
    public function getAttachment(Player $player) {
        $uniqueId = $this->getValidUUID($player);

        if (!isset(self::$attachments[$uniqueId]))
            throw new RuntimeException("Tried to calculate permissions on " . $player->getName() . " using null attachment");

        return self::$attachments[$uniqueId];
    }

    /**
     * @param Player $player
     *
     * @return int|null
     */
    public function getValidUUID(Player $player) {
        $uuid = $player->getUniqueId();
        if ($uuid instanceof UUID)
            return $uuid->toString();
        return null;
    }

    /**
     * @param string $rank
     * @param string $format
     */
    public function setFormat(string $rank, string $format) {
        $config = new Config(Core::getInstance()->getDataFolder() . "Ranks/Formats.json", Config::JSON);
        $config->set($rank, $format);
        $config->save();
    }

    /**
     * @param Player|string $player
     * @param string $rank
     */
    public function setRank($player, string $rank) {
        if ($player instanceof Player) {
            $name = strtolower($player->getName());
        } else {
            $name = strtolower($player);
        }
        $config = new Config(Core::getInstance()->getDataFolder() . "Ranks/Players.json", Config::JSON);
        if ($config->exists($name)) {
            $config->set($name, array($rank, $config->get($name)[1]));
            $config->save();
        } else {
            $config->set($name, array($rank, ""));
            $config->save();
        }
        if ($player instanceof Player) {
            $this->updatePermissions($player);
            $this->updateNametag($player);
        }
    }

    /**
     * @param string $rank
     */
    public function addRank(string $rank) {
        $defaultFormat = "[{fac_rank}{fac_name}][{$rank}§7] {display_name} : {msg}";
        $config = new Config(Core::getInstance()->getDataFolder() . "Ranks/Formats.json", Config::JSON);
        $config->set($rank, $defaultFormat);
        $config->save();
        $config = new Config(Core::getInstance()->getDataFolder() . "Ranks/Permissions.json", Config::JSON);
        $config->set($rank, array());
        $config->save();
        $defaultFormat = "§7{$rank}§7]\n{display_name}";
        $config = new Config(Core::getInstance()->getDataFolder() . "Ranks/Nametag.json", Config::JSON);
        $config->set($rank, $defaultFormat);
        $config->save();
    }

    /**
     * @param string $rank
     */
    public function rmRank(string $rank) {
        $config = new Config(Core::getInstance()->getDataFolder() . "Ranks/Formats.json", Config::JSON);
        $config2 = new Config(Core::getInstance()->getDataFolder() . "Ranks/Permissions.json", Config::JSON);
        $config3 = new Config(Core::getInstance()->getDataFolder() . "Ranks/Nametag.json", Config::JSON);
        $config->remove($rank);
        $config2->remove($rank);
        $config3->remove($rank);
        $config->save();
        $config2->save();
        $config3->save();
    }

    /**
     * @param string $rank
     *
     * @return bool
     */
    public function existRank(string $rank) {
        $config = new Config(Core::getInstance()->getDataFolder() . "Ranks/Formats.json", Config::JSON);
        return $config->exists($rank);
    }

    /**
     * @return array
     */
    public function getAllRanks() {
        $config = new Config(Core::getInstance()->getDataFolder() . "Ranks/Formats.json", Config::JSON);
        return $config->getAll();
    }

    /**
     * @param Player|string $player
     *
     * @return string
     */
    public function getRankColored($player) {
        $group = $this->getRank($player);
        if ($group == "Joueur") return "§8Joueur";
        if ($group == "VIP") return "§eVIP";
        if ($group == "VIPPLUS") return "§6VIP+";
        if ($group == "Hero") return "§9Héro";
        if ($group == "Champion") return "§dChampion";
        if ($group == "Youtubeur") return "§cYoutubeur";
        if ($group == "Guide") return "§aGuide";
        if ($group == "ModoTest") return "§dModérateur§7-§dTest";
        if ($group == "Modo") return "§dModérateur";
        if ($group == "SuperModo") return "§5Super§7-§5Modérateur";
        if ($group == "Developpeur") return "§eDéveloppeur";
        if ($group == "ResponsableModo") return "§5Réponsable§7-§5Modérateur";
        if ($group == "Responsable") return "§4Responsable§7-§4Staff";
        if ($group == "Admin") return "§cAdministrateur";
        if ($group == "Buildeur") return "§2Buildeur";
        if ($group == null) return "§c...";
        return "§c...";
    }

    /**
     * @param Player|string $player
     * @param string $msg
     *
     * @return string
     */
    public function formatMessage($player, string $msg) {
        $rank = $this->getRank($player);
        $tagAPI = new TagAPI();
        $tag = $tagAPI->getTag($player);
        $format = $this->getChatFormat($rank);
        if($tag === null){
            $format = str_replace("{tag}", "", $format);
        }else{
            $format = str_replace("{tag}", "#".$tag, $format);
        }
        $faction = $this->getFactionName($player);
        $factionrank = $this->getFactionRank($player);
        $name = $player->getName();
        $format = str_replace("{fac_rank}", $factionrank, $format);
        $format = str_replace("{fac_name}", $faction, $format);
        $format = str_replace("{display_name}", $name, $format);
        $format = str_replace("{msg}", $msg, $format);
        return $format;
    }

    /**
     * @param Player|string $player
     * @param string $msg
     *
     * @return string
     */
    public function formatMessageOutTag($player, string $msg) {
        $rank = $this->getRank($player);
        $faction = $this->getFactionName($player);
        $factionrank = $this->getFactionRank($player);
        $name = $player->getName();
        $format = $this->getChatFormat($rank);
        $format = str_replace("{tag}", "", $format);
        $format = str_replace("{fac_rank}", $factionrank, $format);
        $format = str_replace("{fac_name}", $faction, $format);
        $format = str_replace("{display_name}", $name, $format);
        $format = str_replace("{msg}", $msg, $format);
        return $format;
    }

    /**
     * @param Player|string $player
     *
     * @return string
     */
    public function getTag($player) {
        if ($player instanceof Player) {
            $player = $player->getName();
        }
        $name = strtolower($player);
        $config = new Config(Core::getInstance()->getDataFolder() . "Ranks/Players.json", Config::JSON);
        return $config->get($name)[1];
    }
    public function getAPI()
    {
    return Server::getInstance()->getPluginManager()->getPlugin("PiggyFactions");
    }
    public function getFactionName(Player $player) {
        $member = $this->getAPI()->getPlayerManager()->getPlayer($player);
        $faction = $member === null ? null : $member->getFaction();
        if($faction === null) {
            return "";
        }
        return $faction->getName();
    }

    /**
     * @param Player $player
     *
     * @return string
     */
    public function getFactionRank(Player $player) {
        $member = $this->getAPI()->getPlayerManager()->getPlayer($player);
        $symbol = $member === null ? null : $this->getAPI()->getTagManager()->getPlayerRankSymbol($member);
        if($member === null || $symbol === null) {
            return "";
        }
        return $symbol;
    }

    /**
     * @param string $rank
     *
     * @return string
     */
    public function getChatFormat(string $rank) {
        $config = new Config(Core::getInstance()->getDataFolder() . "Ranks/Formats.json", Config::JSON);
        return $config->get($rank);
    }

    /**
     * @param Player|string $player
     * @param string $tag
     */
    public function setTag($player, string $tag) {
        if ($player instanceof Player) {
            $name = strtolower($player->getName());
        } else {
            $name = strtolower($player);
        }
        $config = new Config(Core::getInstance()->getDataFolder() . "Ranks/Players.json", Config::JSON);
        $config->set($name, array($config->get($name)[0], $tag));
        $config->save();
        if ($player instanceof Player) {
            $this->updateNametag($player);
        }
    }

    /**
     * @param Player|string $player
     * @param string $permission
     */
    public function adduPermissions($player, string $permission) {
        if ($player instanceof Player) {
            $name = strtolower($player->getName());
            $config = new Config(Core::getInstance()->getDataFolder() . "Ranks/UPermissions.json", Config::JSON);
            $array = $config->get($name);
            array_push($array, $permission);
            $config->set($name, $array);
            $config->save();
            $this->updatePermissions($player);
        }
    }

    /**
     * @param Player|string $player
     * @param string $permission
     */
    public function rmuPermissions($player, string $permission) {
        if ($player instanceof Player) {
            $player = $player->getName();
        }
        $name = strtolower($player);
        $config = new Config(Core::getInstance()->getDataFolder() . "Ranks/UPermissions.json", Config::JSON);
        $array = $config->get($name);
        if (!in_array($permission, $array)) return;
        unset($array[array_search($permission, $array)]);
        sort($array);
        $config->set($name, $array);
        $config->save();
        $this->updatePermissions($player);
    }

    /**
     * @param string $rank
     * @param string $permission
     */
    public function addPermissions(string $rank, string $permission) {
        $config = new Config(Core::getInstance()->getDataFolder() . "Ranks/Permissions.json", Config::JSON);
        $array = $config->get($rank);
        array_push($array, $permission);
        $config->set($rank, $array);
        $config->save();

        foreach ($this->plugin->getServer()->getOnlinePlayers() as $player){
            $rang = $this->getRank($player);
            if($rang == $rank){
                $this->updatePermissions($player);
            }
        }
    }

    /**
     * @param string $rank
     * @param string $permission
     */
    public function rmPermissions(string $rank, string $permission) {
        $config = new Config(Core::getInstance()->getDataFolder() . "Ranks/Permissions.json", Config::JSON);
        $array = $config->get($rank);
        if (!in_array($permission, $array)) return;
        unset($array[array_search($permission, $array)]);
        sort($array);
        $config->set($rank, $array);
        $config->save();

        foreach ($this->plugin->getServer()->getOnlinePlayers() as $player){
            $rang = $this->getRank($player);
            if($rang == $rank){
                $this->updatePermissions($player);
            }
        }
    }

    /**
     * @param Player $player
     */
    public function registerPlayer(Player $player) {
        $this->plugin->getLogger()->debug("Joueur {$player->getName()} bien enregistré");
        $uniqueId = $this->getValidUUID($player);
        $attachment = $player->addAttachment($this->plugin);
        self::$attachments[$uniqueId] = $attachment;
        $this->updatePermissions($player);
    }

    /**
     * @param Player|string $player
     *
     * @return array
     */
    public function getAllUPerms($player){
        if ($player instanceof Player) {
            $player = $player->getName();
        }
        $player = strtolower($player);
        $config = new Config(Core::getInstance()->getDataFolder() . "Ranks/UPermissions.json", Config::JSON);
        return $config->get($player);
    }

    /**
     * @param string $rank
     *
     * @return array
     */
    public function getAllPerms(string $rank){
        $config = new Config(Core::getInstance()->getDataFolder() . "Ranks/Permissions.json", Config::JSON);
        return $config->get($rank);
    }

    /**
     * @param Player|string $player
     */
    public function existuperm($player) {
        if ($player instanceof Player) {
            $player = $player->getName();
        }
        $name = strtolower($player);
        $config = new Config(Core::getInstance()->getDataFolder() . "Ranks/UPermissions.json", Config::JSON);
        $value = $config->exists($name);
        if ($value == true) return;
        if ($value == false) {
            $config->set($name, array());
            $config->save();
        }
    }

    /**
     * @param Player $player
     * @param string $rank
     *
     * @return string
     */
    public function getNametag(Player $player, string $rank) {
        $config = new Config(Core::getInstance()->getDataFolder() . "Ranks/Nametag.json", Config::JSON);
        $nametag = $config->get($rank);
        $tag = $this->getTag($player);
        $factionrank = $this->getFactionRank($player);
        $faction = $this->getFactionName($player);
        $name = $player->getName();
        $nametag = str_replace("{tag}", $tag, $nametag);
        $nametag = str_replace("{fac_rank}", $factionrank, $nametag);
        $nametag = str_replace("{fac_name}", $faction, $nametag);
        $nametag = str_replace("{display_name}", $name, $nametag);
        $nametag = str_replace("{line}", "\n ", $nametag);
        return $nametag;
    }

    /**
     * @param Player $player
     * @param string $rank
     */
    public function setNametag(string $rank, string $nametag) {
        $config = new Config(Core::getInstance()->getDataFolder() . "Ranks/Nametag.json", Config::JSON);
        $config->set($rank, $nametag);
        $config->save();
    }

    /**
     * @param Player|string $player
     */
    public function updateNametag($player){
        if (!$player instanceof Player) {
            return;
        }
        $rank = $this->getRank($player);
        $nametag = $this->getNametag($player, $rank);
        $player->setNameTag($nametag);
    }
}