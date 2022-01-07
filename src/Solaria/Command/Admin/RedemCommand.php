<?php

namespace Solaria\Command\Admin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Solaria\Core;
use Solaria\Tasks\RedemTask;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class RedemCommand extends Command {

    public function __construct() {
        parent::__construct("redem", "Permet de redémarrer le serveur.");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        if (!($sender->hasPermission(Permissions::REDEM))) return $sender->sendMessage(Utils::getPrefix() . "§cVous n'avez pas la permisison de faire ceci. (§eadmin.redem§c).");
        if (isset($args[0])) {

            if ($args[0] == "force") {

                Core::getInstance()->getServer()->shutdown();
                Utils::sendWebHook("・**{$sender->getName()}** viens de redem le serveur.", "**REDEM**", "drop_your_webhook_link");

            }else{

                $sender->sendMessage(Utils::getPrefix() . "Usage: §b/redem (force)§7.");

            }

        }else{

            Core::getInstance()->getScheduler()->scheduleRepeatingTask(new RedemTask($sender), 20);

        }

    }

}
