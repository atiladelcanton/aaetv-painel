<?php


namespace App\ZenSolutions\Helpers;


final class Players
{

    private static $players = ['SmartUp','SS IPTV','Duplex Iptv','Smart Iptv','Smart STB','BRTV P2P', 'XC IPTV'];
    public static function renderPlayers() : array{
        return self::$players;
    }
}
