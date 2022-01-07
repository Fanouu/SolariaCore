<?php

namespace Solaria\Command\Grade;

use Form\CustomForm;
use Form\SimpleForm;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class ParticleCommand extends Command{
    public function __construct()
    {
        parent::__construct("particle", "Permet d'ajouter des particules");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player){
            $this->ParticleForm($sender);
        }
    }
    public function ParticleForm(Player $p){
        $form = new SimpleForm(function (Player $p, int $d){
            $r = $d;
            $c = Utils::$walk;
            if($r === null){
                return true;
            }
            switch ($r){
                case 0:
                    $c->set($p->getName(), false);
                    $c->save();
                    break;
                case 1:
                    if(!$p->hasPermission(Permissions::P_REDSTONE)) return $p->sendMessage(Utils::getPrefix() . "Tu n'as pas la permission de faire ceci");
                    $c->set($p->getName(), "red");
                    $c->save();
                    break;
                case 2:
                    if(!$p->hasPermission(Permissions::P_LAVA)) return $p->sendMessage(Utils::getPrefix() . "Tu n'as pas la permission de faire ceci");
                    $c->set($p->getName(), "lava");
                    $c->save();
                    break;
                case 3:
                    if(!$p->hasPermission(Permissions::P_FIRE)) return $p->sendMessage(Utils::getPrefix() . "Tu n'as pas la permission de faire ceci");
                    $c->set($p->getName(), "fire");
                    $c->save();
                    break;
                case 4:
                    if(!$p->hasPermission(Permissions::P_WATER)) return $p->sendMessage(Utils::getPrefix() . "Tu n'as pas la permission de faire ceci");
                    $c->set($p->getName(), "water");
                    $c->save();
                    break;
            }
            return true;
        });
        $form->setTitle("§l§9Solaria §1Particle");
        $form->addButton("§l»§r§1 Retiré");
        $form->addButton("§l» §r§9Redstone");
        $form->addButton("§l» §r§9lava");
        $form->addButton("§l» §r§9Fire");
        $form->addButton("§l» §r§9Water");
        $form->sendToPlayer($p);
        return $form;
    }
}