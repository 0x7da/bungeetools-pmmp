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

class ListCommand extends Command{
    public function __construct(String $description, String $usage, String $noperm, String $perm)
    {
        parent::__construct("list", $description, $usage);
        $this->setPermissionMessage($noperm);
        $this->setPermission($perm);
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if($sender instanceof Player){
            if(isset($args[0])){
                $s = $args[0];
            }else{
                $s = "ALL";
            }
            $pk = BufferFactory::constructPacket(["server" => $s], RequestType::TYPE_GET_PLAYER_LIST);
            RequestPool::addRequest($sender, new Request($pk->eventData, $sender->getName(), RequestType::TYPE_GET_PLAYER_LIST, function(array $result, array $extra){
                if(($player = Server::getInstance()->getPlayerExact($extra["player"])) instanceof Player){
                    if($extra["server"] == "ALL"){
                        var_dump($result);
                        $player->sendMessage("Global Players Online ( " . count($result["players"]) . " ): " . implode(", ", $result["players"]));
                    }else{
                        $player->sendMessage("Players online on " . $extra["server"] . " ( " . count($result["players"]) . " ): " . implode(", ", $result["players"]));
                    }
                }
            }, ["player" => $sender->getName(), "server" => $s]));
            $sender->sendDataPacket($pk);
        }
    }
}