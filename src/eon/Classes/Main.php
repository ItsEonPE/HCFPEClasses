<?php
namespace eon\Classes;

use pocketmine\entity\Effect;
use pocketmine\event\entity\EntityArmorChangeEvent;
use pocketmine\event\Listener;
use pocketmine\item\Item;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\PluginTask;

class Main extends PluginBase implements Listener {
	public function onEnable() {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	public function onArmourChange(EntityArmorChangeEvent $ev) {
		$entity = $ev->getEntity();
		if($entity instanceof Player) {
			$this->getServer()->getScheduler()->scheduleDelayedTask(new class($this, $entity->getName()) extends PluginTask {
				public function __construct(Plugin $owner, string $player) {
					parent::__construct($owner);
					$this->player = $player;
				}

				public function onRun(int $currentTick) {
					/** @var Player|null $entity */
					$entity = $this->getOwner()->getServer()->getPlayer($this->player);
					if(count($entity->getInventory()->getArmorContents()) === 4) {
						/** @var Item[] $slots */
						$slots = $entity->getInventory()->getArmorContents();
						if(
							$slots[0]->getId() === Item::LEATHER_HELMET and
							$slots[1]->getId() === Item::LEATHER_CHESTPLATE and
							$slots[2]->getId() === Item::LEATHER_LEGGINGS and
							$slots[3]->getId() === Item::LEATHER_BOOTS
						) {
							$entity->addEffect(Effect::getEffect(Effect::SPEED)->setAmplifier(2)->setDuration(INT32_MAX));
							$entity->addEffect(Effect::getEffect(Effect::DAMAGE_RESISTANCE)->setDuration(INT32_MAX));
							return;
						}
						if(
							$slots[0]->getId() === Item::IRON_HELMET and
							$slots[1]->getId() === Item::IRON_CHESTPLATE and
							$slots[2]->getId() === Item::IRON_LEGGINGS and
							$slots[3]->getId() === Item::IRON_BOOTS
						) {
							$entity->addEffect(Effect::getEffect(Effect::NIGHT_VISION)->setDuration(INT32_MAX));
							$entity->addEffect(Effect::getEffect(Effect::FIRE_RESISTANCE)->setDuration(INT32_MAX));
							$entity->addEffect(Effect::getEffect(Effect::HASTE)->setAmplifier(1)->setDuration(INT32_MAX));
							$entity->addEffect(Effect::getEffect(Effect::INVISIBILITY)->setDuration(INT32_MAX));
							return;
						}
						if(
							$slots[0]->getId() === Item::GOLD_HELMET and
							$slots[1]->getId() === Item::GOLD_CHESTPLATE and
							$slots[2]->getId() === Item::GOLD_LEGGINGS and
							$slots[3]->getId() === Item::GOLD_BOOTS
						) {
							$entity->addEffect(Effect::getEffect(Effect::REGENERATION)->setAmplifier(1)->setDuration(INT32_MAX));
							$entity->addEffect(Effect::getEffect(Effect::SPEED)->setAmplifier(1)->setDuration(INT32_MAX));
							return;
						}
						if(
							$slots[0]->getId() === Item::CHAIN_HELMET and
							$slots[1]->getId() === Item::CHAIN_CHESTPLATE and
							$slots[2]->getId() === Item::CHAIN_LEGGINGS and
							$slots[3]->getId() === Item::CHAIN_BOOTS
						) {
							$entity->addEffect(Effect::getEffect(Effect::JUMP)->setAmplifier(1)->setDuration(INT32_MAX));
							$entity->addEffect(Effect::getEffect(Effect::SPEED)->setAmplifier(2)->setDuration(INT32_MAX));
							$entity->addEffect(Effect::getEffect(Effect::STRENGTH)->setDuration(INT32_MAX));
							return;
						}
						$entity->removeAllEffects();
					}
				}
			}, 5); // Plugin by @EonIsDead [ https://github.com/ItsEonPE/HCFPEClasses ]
		}
	}
}
