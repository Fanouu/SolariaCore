<?php

namespace Solaria\Command\Grade;

use pocketmine\block\Block;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\defaults\TitleCommand;
use pocketmine\item\StringItem;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\Player;
use pocketmine\tile\EnderChest;
use pocketmine\tile\Tile;
use Solaria\Utils\Permissions;
use Solaria\Utils\Utils;

class EnderChestCommand extends Command {

    public function __construct() {
        parent::__construct("ec", "Permet  d'ouvrir son enderchest.", "", ["enderchest"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {

        if (!$sender instanceof Player)return $sender->sendMessage(Utils::getPrefix() . "Utilisez cette commande en jeu.");
        if (!($sender->hasPermission(Permissions::ENDERCHEST))) return $sender->sendMessage(Utils::getPrefix() . "§cVous n'avez pas la permission d'ouvrir votre enderchest. (§egrade.enderchest§c).");
        $nbt = new CompoundTag("", [new StringTag("id", Tile::CHEST), new StringTag("CustomName", "EnderChest"), new IntTag("x", (int)floor($sender->x)), new IntTag("y", (int)floor($sender->y) - 4), new IntTag("z", (int)floor($sender->z))]);
        $tile = Tile::createTile("EnderChest", $sender->getLevel(), $nbt);
        $block = Block::get(Block::ENDER_CHEST);
        $block->x = (int)$tile->x;
        $block->y = (int)$tile->y;
        $block->z = (int)$tile->z;
        $block->level = $tile->getLevel();
        $block->level->sendBlocks([$sender], [$block]);
        if ($tile instanceof EnderChest) {

            $sender->getEnderChestInventory()->setHolderPosition($tile);
            $sender->addWindow($sender->getEnderChestInventory());

        }

        return true;
    }

}