<?php

namespace tobiasdev\bungeetools;

use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\ScriptCustomEventPacket;
use tobiasdev\bungeetools\protocol\Request;
use tobiasdev\bungeetools\protocol\RequestPool;
use tobiasdev\bungeetools\protocol\StringStream;

class EventListener implements Listener
{
    public function onPacketReceive(DataPacketReceiveEvent $event)
    {
        $packet = $event->getPacket();
        if ($packet instanceof ScriptCustomEventPacket) {
            if ($packet->eventName == "bungeecord:main") {
                $request = RequestPool::getRequestForPlayer($event->getPlayer()->getName());
                if ($request instanceof Request) {
                    $request->notify($packet->eventData);
                }
            }
        }
    }
}