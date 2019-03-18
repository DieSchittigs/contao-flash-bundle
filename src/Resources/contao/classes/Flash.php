<?php

namespace Contao;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBag;

class Flash {

 /**
 * Stores, retreives and purges flash messages in user session
 *
 * @property string  $id
 * @property boolean $autoDismiss
 * @property string  $type
 * @property array   $cssClasses
 * @property string  $namespace

 * @method static Flash warn($message)
 * @method static Flash error($message)
 * @method static Flash info($message)
 * @method static Flash success($message)
 *
 */
    
    protected static $sessionKey = '__cfb';
    protected static $flashes = [];
    public $id;
    public $autoDismiss = true;
    public $type = 'info';
    public $cssClasses = [];
    public $namespace = '';
    public $message = '';

    /**
     * @return Session Symfony session
     */
    private static function getSession(){
        return System::getContainer()->get('session');
    }

    /**
     * @return FlashBag Symfony session default flash bag
     */
    private static function getFlashBag(){
        return self::getSession()->getFlashBag();
    }

    public static function load(){
        self::$flashes = self::getSession()->get(self::$sessionKey);
        return self::$flashes;
    }

    public static function commit(Flash $flash = null){
        if($flash){
            self::purge($flash->id);
            self::$flashes[] = $flash;
        }
        self::getSession()->set(self::$sessionKey, self::$flashes);
    }

    public static function purge($id){
        foreach(self::load() as $index => $flash){
            if($flash->id == $id) unset(self::$flashes[$index]);
        }
        self::commit();
    }

    public function __construct($args = []){
        $this->id = uniqid();
        foreach($args as $key => $val){
            if(!property_exists($this, $key)) continue;
            $this->{$key} = $val;
        }
    }

    public static function __callStatic($name, $arguments){
        $flash = new self([
            'type' => $name,
            'cssClasses' => [$name],
            'message' => implode(' ', $arguments)
        ]);
        self::commit($flash);
        return $flash;
    }

    public function setAutoDismiss(bool $enable){
        $this->autoDismiss = $enable;
        self::commit($this);
        return $this;
    }

    public function addClass($cssClasses){
        if(is_string($cssClasses)) $cssClasses = [$cssClasses];
        $this->cssClasses = array_merge($this->cssClasses, $cssClasses);
        self::commit($this);
        return $this;
    }

    public function setNamespace($namespace){
        $this->namespace = $namespace;
        self::commit($this);
        return $this;
    }
}
