<?php

namespace tobiasdev\bungeetools\commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\MainLogger;
use tobiasdev\bungeetools\API;
use tobiasdev\bungeetools\protocol\BufferFactory;
use tobiasdev\bungeetools\protocol\Request;
use tobiasdev\bungeetools\protocol\RequestPool;
use tobiasdev\bungeetools\protocol\RequestType;

class ConnectCommand extends Command
{
    public function __construct(String $description, String $usage, String $noperm, String $perm)
    {
        parent::__construct("connect", $description, $usage);
        $this->setPermissionMessage($noperm);
        $this->setPermission($perm);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(count($args) >= 1){
            if($sender instanceof Player){
                $pk = BufferFactory::constructPacket(["server" => $args[0]], RequestType::TYPE_GET_SERVER_IP);
                RequestPool::addRequest($sender, new Request($pk->eventData, $sender->getName(), RequestType::TYPE_GET_SERVER_IP, function(array $result, array $extradata){
                    if(isset($result["servername"]) && isset($result["ip"])){
                        if($result["port"] != null){
                            if($extradata["sender"] instanceof Player && $extradata["sender"]->isOnline()){
                                API::transferPlayer($extradata["sender"], $result["servername"]);
                            }else{
                                MainLogger::getLogger()->info("Not online!");
                            }
                        }else{
                            $extradata["sender"]->sendMessage("Server not found!");
                        }
                    }else{
                        MainLogger::getLogger()->info("Result incomplete");
                    }
                }, ["sender" => $sender]));
                $sender->sendDataPacket($pk);
            }
        }else{
            $sender->sendMessage($this->getUsage());
        }
    }
}