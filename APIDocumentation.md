# BlockSniper API Documentation

<br>

### Getting an instance of BlockHorizons\BlockSniper\Loader
To get an instance of the main class of BlockSniper, the Loader class, add this code on enable.
```php
public $blockSniperPlugin;
  
public function onEnable() {
    $this->blockSniperPlugin = $this->getServer()->getPluginManager()->getPlugin("BlockSniper");
}
```
From here on inside functions in the plugin can be called.

<br>

### Hooking into BlockSniper events
Hooking into BlockSniper events is very easy, and follows the same usage as a normal PocketMine event would. Hooking in the events would require registering events, implementing Listener and adding a function. Some events are cancellable, some are not.
```php
<?php

namespace Me\MyPlugin;
    
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use BlockHorizons\BlockSniper\events\BrushUseEvent;
    
class MyClass extends PluginBase implements Listener {
    
    public function onEnable() {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
    
    public function onBrushUse(BrushUseEvent $event) {
        if(strtolower($event->getPlayer()->getName()) === "steve") {
            $event->setCancelled();
        }
    }
}
```
|Event|Cancellable|
|-----|-----------|
|BrushRecoverEvent|True|
|BrushUseEvent|True|
|ChangeBrushPropertiesEvent|False|
|PresetCreationEvent|True|

<br>

### Registering new Shapes
BlockSniper adds very easy to use API for adding new Shapes and Types. A new Shape or Type class requires at LEAST the following:
```php
<?php
    
namespace MyPlugin\MyShapes;
    
use BlockHorizons\BlockSniper\brush\BaseShape;
use pocketmine\Player;
use pocketmine\level\Level;
use pocketmine\level\Position;
    
class MyShape extends BaseShape {
	
	const ID = 5;
    
    /*
     * This function should return an array containing the blocks collected in the shape.
     */
    public function getBlocksInside(bool $partially = false, int $blocksPerTick = 100): array {
        return [];
    }
    
    public function getName(): string {
        return "";
    }
    
    public function getApproximateProcessedBlocks(): int {
        return 0;
    }
    
    public function getTouchedChunks(): array {
    	return [];
    }
}
```

In order to make this new shape able to be used, the following code should be executed anywhere in your plugin:
```php
\BlockHorizons\BlockSniper\brush\registration\ShapeRegistration::registerShape(MyShape::class, MyShape::ID);
```

<br>

### Registering new Types
Registering new types is very similar to the registering of types. Only a couple small things are different. No further explanation should be needed, see the example below.
```php
<?php
    
namespace MyPlugin\MyTypes;
    
use BlockHorizons\BlockSniper\brush\BaseType;
use pocketmine\level\Level;
use pocketmine\Player;
    
class MyType extends BaseType {
	
    public function __construct(Player $player, Level $level, array $blocks) {
        parent::__construct($player, $level, $blocks);
    }
    
    /*
     * This function should return an array containing the undo blocks.
     */
    public function fillSynchronously(): array {
        return [];
    }
    
    /*
     * This function is optional, and could be left if the function below is added.
     */
    public function fillAsynchronously(): void {
        
    }
    
    /*
     * The function to specify whether this type can be executed asynchronously or not.
     */
    public function canBeExecutedAsynchronously(): bool {
        return false;
    }
    
    public function getName(): string {
        return "";
    }
}
```
To register a new type, use:
```php
\BlockHorizons\BlockSniper\brush\registration\TypeRegistration::registerType(MyType::class, MyType::ID);
```

<br>

### Getting the Brush of a player
Getting the brush of a player is very easy. A brush object of a player can be obtained by using:
```php
<?php
/** var pocketmine\Player $player */
if(($session = \BlockHorizons\BlockSniper\sessions\SessionManager::getPlayerSession($player)) === null) {
    return false;
}
$brush = $session->getBrush();
$brush->setSize(10);
$brush->setHollow();
?>
```
Make sure to check if the brush obtained from BrushManager::get() is a Brush object, and not null, which will happen if the player has no brush initialized.

<br><br>

Hopefully this API introduction was helpful. If there's anything you think should be added, make sure to say so in the [issues](https://github.com/BlockHorizons/BlockSniper/issues) or contact us on our [Gitter chat](https://gitter.im/BlockHorizons/BlockSniper)

