<?php
namespace tobiasdev\bungeetools;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use tobiasdev\bungeetools\commands\KickPlayerCommand;

class BungeeTools extends PluginBase{
    /** @var Config */
    public static $messages, $config;
	 public function onEnable ()
	 {

		  if(!file_exists($this->getDataFolder() . "messages.yml")){
		  	 $this->saveResource("messages.yml");
		  }
         if(!file_exists($this->getDataFolder() . "config.yml")){
             $this->saveResource("config.yml");
         }
		  self::$messages = new Config($this->getDataFolder() . "messages.yml", Config::YAML);
		  self::$config = new Config($this->getDataFolder() . "config.yml", Config::YAML);

		  if((bool) self::$config->getNested("overwrite-commands.kick") === true){
              $this->getServer()->getCommandMap()->unregister($this->getServer()->getCommandMap()->getCommand("kick"));
              $this->getServer()->getCommandMap()->register($this->getName(), new KickPlayerCommand(self::$config->getNested("command-config.kick.description"), self::$config->getNested("command-config.kick.usage"), self::$config->getNested("command-config.kick.noperm-message"), self::$config->getNested("command-config.kick.permission")));
              $this->getLogger()->info("Successfully overwritten PocketMines KICK Command!");
          }
		  $this->getServer()->getPluginManager()->registerEvents(new EventListener(), $this);
	 }

	 public static function formatMessage(String $key, array $replacing): ?string {
	     $str = self::$messages->get($key);
	     if(is_string($str)){
	         $str = str_replace("{line}", PHP_EOL, $str);
	         foreach(array_keys($replacing) as $r){
	             $str = str_replace($r, $replacing[$r], $str);
             }
	         return $str;
         }
	     return null;
     }
}