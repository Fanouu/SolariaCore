<?php

namespace Solaria\Command\Joueur;

use Form\CustomForm;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Solaria\Core;
use Solaria\Utils\Utils;

class ReportCommand extends Command {

    public function __construct() {
        parent::__construct("report", "Permet de signaler une personne.");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        if ($sender instanceof Player) {

            $this->report($sender);

        }else{

            $sender->sendMessage(Utils::getPrefix() . "Utilisez cette command en jeu.");

        }

    }

    public function report(Player $sender) {

        $form = new CustomForm(function (Player $sender, array $data = null){


            if ($data === null) {

                $sender->sendMessage(Utils::getPrefix() . "Votre report a été fermer.");
                return true;
            }

            Utils::sendWebHook("・**{$sender->getName()}** a report **{$data[1]}** pour **{$data[2]}**.", "**REPORT**", "https://discord.com/api/webhooks/889904069064413304/AGvKBt0uDhq_nvo83RLkIFni3xKZ0U4HOy-TVjJHD6ac6pjWXMuUNEsv3m0-e04ACpoO");
            $sender->sendMessage(Utils::getPrefix() . "Votre report a bien été envoyez aux membres du staff.");

        });

        $form->setTitle("§b- §7Report §b-");
        $form->addLabel("§7-> Choisissez un joueur que vous voulez report.");
        $form->addInput("Merci de mettre un joueur.");
        $form->addInput("Merci de mettre une raison.", "Choisissez une raison.", "Cheat");
        $form->sendToPlayer($sender);
        return $form;

    }

}