<?php
namespace tobiasdev\bungeetools;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\ScriptCustomEventPacket;
use tobiasdev\bungeetools\protocol\StringStream;

class EventListener implements  Listener{
    public function onPacketReceive(DataPacketReceiveEvent $event){
        $packet = $event->getPacket();
        if($packet instanceof ScriptCustomEventPacket){
            if ( $packet->eventName == "bungeecord:main" ) {
                $reader = new StringStream($packet->eventData);
                var_dump("TEST1: " . $reader->readString());
                var_dump("TEST2: " . $reader->readString());
                $event->getPlayer()->sendMessage("Currently players online: " . $reader->readInt());
            }
        }
    }
}