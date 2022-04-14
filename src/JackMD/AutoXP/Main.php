<?php

/**
 *   ___        _       __   ________
 *  / _ \      | |      \ \ / /| ___ \
 * / /_\ \_   _| |_ ___  \ V / | |_/ /
 * |  _  | | | | __/ _ \ /   \ |  __/
 * | | | | |_| | || (_) / /^\ \| |
 * \_| |_/\__,_|\__\___/\/   \/\_|
 *
 * Creator:
 *   Discord: JackMD#3717
 *   Twitter: JackMTaylor_
 *
 * Updated by:
 *   Discord:
 *      Tag: Kaneki Le Chomeur#2833
 *      Id: 568874566869581835
 * 
 * This software is distributed under "GNU General Public License v3.0".
 * This license allows you to use it and/or modify it but you are not at
 * all allowed to sell this plugin at any cost. If found doing so the
 * necessary action required would be taken.
 *
 * AutoXP is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License v3.0 for more details.
 *
 * You should have received a copy of the GNU General Public License v3.0
 * along with this program. If not, see
 * <https://opensource.org/licenses/GPL-3.0>.
 * ------------------------------------------------------------------------
 */

namespace JackMD\AutoXP;

use pocketmine\entity\ExperienceManager;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeathEvent;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener {

	public function onEnable(): void {
		$this->getServer()->getPluginManager()->registerEvents(($this), $this);
		$this->getLogger()->info("[AutoXP] Plugin Enabled.");
	}

	/**
	 * @param BlockBreakEvent $event
	 * @priority HIGHEST
	 */
	public function onBreak(BlockBreakEvent $event) {
		if ($event->isCancelled()) {
			return;
		}
        	$expmanager = new ExperienceManager($event->getPlayer());
		$expmanager->addXp($event->getXpDropAmount());
		$event->setXpDropAmount(0);
	}


	/**
	 * @param PlayerDeathEvent $event
	 * @priority HIGHEST
	 */
	public function onPlayerKill(PlayerDeathEvent $event) {
		$player = $event->getPlayer();
		$cause = $player->getLastDamageCause();
		if ($cause instanceof EntityDamageByEntityEvent) {
			$damager = $cause->getDamager();
			if ($damager instanceof Player) {
                	$expmanager = new ExperienceManager($damager);
				$expmanager->addXp($player->getXpDropAmount());
				$player->setCurrentTotalXp(0);
			}
		}
	}
}
