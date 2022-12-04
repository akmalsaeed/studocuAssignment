<?php


namespace App\Helpers\Console;


class ConsoleHelper
{

    public static function clearConsole(){
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            system('cls');
        } else {
            system('clear');
        }
    }

}
