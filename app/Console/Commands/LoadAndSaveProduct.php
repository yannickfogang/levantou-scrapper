<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use JetBrains\PhpStorm\NoReturn;
use Module\Application\Scrapper\Load\LoadProductHandler;

class LoadAndSaveProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrapper:load_product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Load product scrapping';


    public function handle(LoadProductHandler $handler){
        $handler->__invoke('B072BWF93B');
        $handler->__invoke('B07NQ89FJJ');
        $handler->__invoke('B07NQFFF3L');
        $handler->__invoke('B012DE7AJY');
    }

}
