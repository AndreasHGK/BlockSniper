<?php

declare(strict_types=1);

namespace BlockHorizons\BlockSniper\brush\types;

use BlockHorizons\BlockSniper\brush\BaseType;
use pocketmine\block\Block;

class WarmType extends BaseType{

	public const ID = self::TYPE_WARM;

	public function fillSynchronously() : \Generator{
		foreach($this->blocks as $block){
			switch($block->getId()){
				case Block::ICE:
					yield $block;
					$this->putBlock($block, Block::WATER);
					break;
				case Block::SNOW_LAYER:
					yield $block;
					$this->putBlock($block, 0);
					break;
				case Block::PACKED_ICE:
					yield $block;
					$this->putBlock($block, Block::ICE);
			}
		}
	}

	public function fillAsynchronously() : void{
		foreach($this->blocks as $block){
			switch($block->getId()){
				case Block::ICE:
					$this->putBlock($block, Block::WATER);
					break;
				case Block::SNOW_LAYER:
					$this->putBlock($block, 0);
					break;
				case Block::PACKED_ICE:
					$this->putBlock($block, Block::ICE);
			}
		}
	}

	public function getName() : string{
		return "Warm";
	}
}