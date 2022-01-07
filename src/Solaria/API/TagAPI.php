<?php
    
namespace Solaria\API;

use pocketmine\utils\Config;
use pocketmine\Player;
use Solaria\Core;

class TagAPI{
    
    public function getTags(Player $player){
        $data = new Config(Core::getInstance()->getDataFolder()."Player/" . $player->getName() . ".json", Config::JSON);
        
        $tagArray = $data->getNested("tag.Tags");
        if($tagArray === null || $tagArray === []){
            $data->setNested("tag.Tags", []);
            $data->save();
            return null;
        }else{
            return $tagArray;
        }
    }
    
    public function getTag(Player $player){
        $data = new Config(Core::getInstance()->getDataFolder()."Player/" . $player->getName() . ".json", Config::JSON);
        
        $tag = $data->getNested("tag.CurrentTag");
        if($tag === null){
            return null;
        }else{
            return $tag;
        }
    }
    
    public function setTag(Player $player, $tag){
        $data = new Config(Core::getInstance()->getDataFolder()."Player/" . $player->getName() . ".json", Config::JSON);
        
        $data->setNested("tag.CurrentTag", $tag);
        $data->save();
    }
    
    public function addTag(Player $player, $tag){
        $data = new Config(Core::getInstance()->getDataFolder()."Player/" . $player->getName() . ".json", Config::JSON);
        $this->getTags($player);
        if($data->getNested("tag.Tags") === null || $data->getNested("tag.Tags") === []){
            $toAdd = [$tag];
        }else{
            $array = $data->getNested("tag.Tags");
            //$player->sendMessage("-". $array);
            var_dump($array);
            $array[] = $tag;
            $toAdd = $array;
        }
        $data->setNested("tag.Tags", $toAdd);
        $data->save();
    }
}