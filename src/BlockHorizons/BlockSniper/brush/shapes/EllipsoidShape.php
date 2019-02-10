<?php

declare(strict_types=1);

namespace BlockHorizons\BlockSniper\brush\shapes;

use BlockHorizons\BlockSniper\brush\Brush;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;

class EllipsoidShape extends SphereShape{

	public const ID = self::SHAPE_ELLIPSOID;

	/**
	 * @return string
	 */
	public function getName() : string{
		return $this->hollow ? "Hollow Ellipsoid" : "Ellipsoid";
	}

	/**
	 * @param Vector3       $center
	 * @param Brush         $brush
	 * @param AxisAlignedBB $bb
	 */
	public function buildSelection(Vector3 $center, Brush $brush, AxisAlignedBB $bb) : void{
		[$bb->maxX, $bb->maxY, $bb->maxZ, $bb->minX, $bb->minY, $bb->minZ] = [
			$center->x + $brush->width, $center->y + $brush->height, $center->z + $brush->length,
			$center->x - $brush->width, $center->y - $brush->height, $center->z - $brush->length
		];
	}

	/**
	 * @return bool
	 */
	public function usesThreeLengths() : bool{
		return true;
	}
}