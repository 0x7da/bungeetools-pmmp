<?php
namespace tobiasdev\bungeetools\commands;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use tobiasdev\bungeetools\API;
use tobiasdev\bungeetools\BungeeTools;

class KickPlayerCommand extends Command{
    public function __construct(String $description, String $usage, String $noperm, String $perm)
    {
        parent::__construct("kick", $description, $usage);
        $this->setPermissionMessage($noperm);
        $this->setPermission($perm);
    }
    public function execute(CommandSender $sender, string $commandLabel, array $args)
    {
        if(count($args) >= 2){
            $target = $args[0];
            array_shift($args);

            API::kickPlayer($target, BungeeTools::formatMessage("kick-message", ["{Reason}" => implode(" ", $args)]));

        }else{
            $sender->sendMessage("§cPlease use /kick <Player> <Reason>");
            API::getPlayers();
        }
    }
}