<?php

namespace Solaria\Command\Admin;

use pocketmine\entity\DataPropertyManager;
use pocketmine\entity\Entity;
use pocketmine\nbt\tag\FloatTag;

trait NPCMove {

    public $namedtag;

    abstract public function getDataPropertyManager(): DataPropertyManager;

    abstract public function setGenericFlag(int $flag, bool $value = true): void;

    public function prepareMetadata(): void {
        $this->setGenericFlag(Entity::DATA_FLAG_IMMOBILE, true);
        if (!$this->namedtag->hasTag("Scale", FloatTag::class)) {
            $this->namedtag->setFloat("Scale", 0.001, true);
        }
        $this->getDataPropertyManager()->setFloat(Entity::DATA_SCALE, $this->namedtag->getFloat("Scale"));
    }

    public function tryChangeMovement(): void {

    }

}