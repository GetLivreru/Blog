<?php

namespace App\Console\Commands;

use App\Services\BotService;
use Illuminate\Console\Command;

class ProcessBotQueue extends Command
{
    protected $signature = 'bots:process';
    protected $description = 'Process the bot queue';

    private BotService $botService;

    public function __construct(BotService $botService)
    {
        parent::__construct();
        $this->botService = $botService;
    }

    public function handle()
    {
        $this->info('Starting to process bot queue...');

        while (true) {
            $this->botService->processQueue();
            sleep(1); // Небольшая пауза между обработкой очереди
        }
    }
} 