<?php

namespace Zoumi;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Player;
use pocketmine\utils\Config;


class Join extends PluginBase implements Listener {

    /** @var Config $conf */
    public $conf;

    public function onEnable()
    {
        $this->getLogger()->info("et Activer !");
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        @mkdir($this->getDataFolder());
        if (!file_exists($this->getDataFolder() . "config.yml")) {
            $this->saveResource('config.yml');
        }
        $this->conf = new Config($this->getDataFolder() . 'config.yml', Config::YAML);
    }

    public function onDisable()
    {
        $this->getLogger()->info("et Désactiver !");
    }

    public function onJoin(PlayerJoinEvent $e) {
        $p = $e->getPlayer();
        $e->setJoinMessage(" ");

        if(!$p->hasPlayedBefore()) {
            Server::getInstance()->broadcastMessage($this->conf->get("color-first-connection-name") . $p->getName() . $this->conf->get("first-connection"));
        }else{
            Server::getInstance()->broadcastPopup($this->conf->get("color-join") . $p->getName() . $this->conf->get("message-join"));
            $p->sendMessage($this->conf->get("welcome-message"));
        }
    }

    public function onQuit(PlayerQuitEvent $e) {
        $p = $e->getPlayer();

        $e->setQuitMessage(" ");
        Server::getInstance()->broadcastPopup($this->conf->get("color-disconect-name") . $p->getName() . $this->conf->get("message-leave"));
    }
}