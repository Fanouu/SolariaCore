<?php

namespace Solaria\Command\Staff;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\Config;
use Solaria\Core;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class MuteChatCommand extends Command {

    public function __construct() {
        parent::__construct("mutechat", "Permet de rendre muet le chat.");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        if (!$sender instanceof Player)return $sender->sendMessage(Utils::getPrefix() . "Utilisez cette commande");
        if (!($sender->hasPermission(Permissions::MUTECHAT))) return $sender->sendMessage(Utils::getPrefix() . "");
        $config = new Config(Core::getInstance()->getDataFolder() . "Config.json", Config::JSON);
        $grade = Core::getRankAPI()->getRankColored($sender);

        if (!isset($args[0])) return $sender->sendMessage(Utils::getPrefix() . "Usage: §b/mutechat <on/off>§7.");

        if ($args[0] == "on") {

            $config->set("MuteChat", true);
            $config->save();
            Core::getInstance()->getServer()->broadcastMessage(Utils::getPrefix() . "Le chat a été désactivé par [{$grade}§7] {$sender->getName()} !");
            Utils::sendWebHook("・Le chat a été désactivé par **{$sender->getDisplayName()}**", "**MUTECHAT**", "https://discord.com/api/webhooks/890199568472502272/w6qcn1LTLdpsdwdGieT2LdoO-wfb-x2D_FscRxhTpdXocipkFbM3PBt52tFsJ8yT0txQ");


        }elseif ($args[0] == "off") {

            $config->set("MuteChat", false);
            $config->save();
            Core::getInstance()->getServer()->broadcastMessage(Utils::getPrefix() . "Le chat a été rétablie par [{$grade}§7] {$sender->getName()} !");
            Utils::sendWebHook("・Le chat a été rétablie par **{$sender->getDisplayName()}**", "**MUTECHAT**", "https://discord.com/api/webhooks/890199568472502272/w6qcn1LTLdpsdwdGieT2LdoO-wfb-x2D_FscRxhTpdXocipkFbM3PBt52tFsJ8yT0txQ");


        }else{

            $sender->sendMessage(Utils::getPrefix() . "Usage: §b/mutechat <on/off>§7.");

        }

        return true;
    }

}