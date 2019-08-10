<?php

namespace tobiasdev\bungeetools\protocol;

use pocketmine\network\mcpe\protocol\ScriptCustomEventPacket;
use tobiasdev\bungeetools\ProtocolUtils;

class BufferFactory
{
    public static function constructBuffer(array $data, int $type): ?string
    {
        switch ($type) {
            case RequestType::TYPE_GET_SERVER_LIST:
                $str = "";
                ProtocolUtils::writeString("GetServers", $str);
                return $str;
                break;
            case RequestType::TYPE_GET_SERVER:
                $str = "";
                ProtocolUtils::writeString("GetServer", $str);
                return $str;
            case RequestType::TYPE_GET_SERVER_IP:
                $str = "";
                ProtocolUtils::writeString("ServerIP", $str);
                ProtocolUtils::writeString($data["server"], $str);
                return $str;
                break;
            case RequestType::TYPE_GET_PLAYER_COUNT:
                $str = "";
                ProtocolUtils::writeString("PlayerCount", $str);
                ProtocolUtils::writeString($data["server"], $str);
                return $str;
                break;
            case RequestType::TYPE_GET_PLAYER_LIST:
                $str = "";
                ProtocolUtils::writeString("PlayerList", $str);
                ProtocolUtils::writeString($data["server"], $str);
                return $str;
                break;
            case RequestType::TYPE_GET_PLAYER_IP:
                $str = "";
                ProtocolUtils::writeString("IP", $str);
                return $str;
                break;
            case RequestType::TYPE_GET_PING:
                $str = "";
                ProtocolUtils::writeString("GetPing", $str);
                ProtocolUtils::writeString($data["player"], $str);
                return $str;
                break;
            default:
                return null;
                break;
        }

    }

    public static function constructPacket(array $data, int $type): ?ScriptCustomEventPacket
    {
        $pk = new ScriptCustomEventPacket();
        $pk->eventName = "bungeecord:main";
        $pk->eventData = self::constructBuffer($data, $type);
        return $pk;
    }
}