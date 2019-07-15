<?php
namespace tobiasdev\bungeetools\commands;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use tobiasdev\bungeetools\protocol\BufferFactory;
use tobiasdev\bungeetools\protocol\Request;
use tobiasdev\bungeetools\protocol\RequestPool;
use tobiasdev\bungeetools\protocol\RequestType;

class ServersCommand extends Command{
    public function __construct()
    {
        parent::__construct("servers", "", "");
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player) {
            $pk = BufferFactory::constructPacket([], RequestType::TYPE_GET_SERVER_LIST);
            RequestPool::addRequest($sender, new Request($pk->eventData, $sender->getName(), RequestType::TYPE_GET_SERVER_LIST, function (array $result, array $extra){
                $player = Server::getInstance()->getPlayerExact($extra["player"]);
                if($player instanceof Player){
                    $player->sendMessage("Registered Servers: " . implode(", ", $result["servers"]));
                }
            }, ["player" => $sender->getName()]));
            $sender->sendDataPacket($pk);

        }
    }
}