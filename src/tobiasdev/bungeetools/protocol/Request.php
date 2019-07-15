<?php
namespace tobiasdev\bungeetools\protocol;
use Closure;

class Request{
    /** @var Closure */
    private $action;
    /** @var string */
    private $query;
    /** @var string */
    private $player;
    /** @var array */
    private $data;
    /** @var Integer */
    private $type;
    public function notify(){
        $action = $this->action;
    }
}