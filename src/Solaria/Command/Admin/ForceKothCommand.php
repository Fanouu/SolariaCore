<?php

namespace Solaria\Command\Admin;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Solaria\Command\Joueur\BoutiqueCommand;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;
use Solaria\Core;

class ForceKothCommand extends Command{

    private $plugin;
    
    public function __construct(Core $plugin)
    {
        parent::__construct("forcekoth", "Permet de forcé le demarage du koth");
        $this->plugin = $plugin;
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(!$sender->hasPermission(Permissions::GIVEPB)) return $sender->sendMessage("Tu n'as pas la permission de faire ceci");
        $sender->sendMessage(Utils::getPrefix() . "Tu as bien forcé le démarage du koth");
        $this->plugin->getKothAPI()->start();
        Utils::sendWebHook("Un événement **KOTH** vient d'être start par un **admin**, soyez le premier à capturer !", "**Event KOTH**", "https://discord.com/api/webhooks/926021554020712471/5koyodiBfFZRU9mSNdpdsoQEToB1exmUumAyVJNF7pPY4e8kDcu8td4zyIwflajI9iIZ");
        return true;
    }
}