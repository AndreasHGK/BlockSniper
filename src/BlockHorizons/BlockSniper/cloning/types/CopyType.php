<?php

declare(strict_types=1);

namespace BlockHorizons\BlockSniper\cloning\types;

use BlockHorizons\BlockSniper\brush\BaseShape;
use BlockHorizons\BlockSniper\cloning\BaseClone;
use BlockHorizons\BlockSniper\sessions\SessionManager;
use pocketmine\level\Position;
use pocketmine\Player;

class CopyType extends BaseClone{

	public function __construct(Player $player, bool $saveAir, Position $center, BaseShape $shape){
		parent::__construct($player, $saveAir, $center, $shape);
	}

	public function getName() : string{
		return "Copy";
	}

	public function saveClone() : void{
		SessionManager::getPlayerSession($this->player)->getCloneStore()->setOriginalCenter($this->center);
		SessionManager::getPlayerSession($this->player)->getCloneStore()->saveCopy($this->shape);
	}
}
