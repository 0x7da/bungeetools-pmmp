<?php
namespace tobiasdev\bungeetools;

use pocketmine\utils\Binary;

class ProtocolUtils
{
	 public static function writeString(String $str, String &$datastream){
	 	 $datastream .= Binary::writeShort(strlen($str)) . $str;
	 }
}