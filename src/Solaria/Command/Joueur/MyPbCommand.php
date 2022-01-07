<?php

namespace Solaria\Command\Joueur;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Solaria\Command\Joueur\BoutiqueCommand;
use Solaria\Utils\Utils;

class MyPbCommand extends Command{
    public function __construct()
    {
        parent::__construct("mypb", "Permet de voir ses pb");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(BoutiqueCommand::$pb->exists($sender->getName())){
            $c = BoutiqueCommand::$pb->get($sender->getName());
        }else{
            $c = 0;
            BoutiqueCommand::$pb->set($sender->getName(), 0);
        }
        $sender->sendMessage(Utils::getPrefix() . "Tu as {$c} point(s) boutique");
    }
}