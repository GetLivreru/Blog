<?php

namespace App\Console\Commands;

use App\Models\Bot;
use App\Services\BotService;
use Illuminate\Console\Command;

class ManageBots extends Command
{
    protected $signature = 'bots:manage {action} {--count=5} {--type=user}';
    protected $description = 'Manage bots: create, start, stop, status';

    private BotService $botService;

    public function __construct(BotService $botService)
    {
        parent::__construct();
        $this->botService = $botService;
    }

    public function handle()
    {
        $action = $this->argument('action');
        $count = $this->option('count');
        $type = $this->option('type');

        switch ($action) {
            case 'create':
                $this->createBots($count, $type);
                break;
            case 'start':
                $this->startBots();
                break;
            case 'stop':
                $this->stopBots();
                break;
            case 'status':
                $this->showStatus();
                break;
            default:
                $this->error('Unknown action. Available actions: create, start, stop, status');
        }
    }

    private function createBots(int $count, string $type): void
    {
        for ($i = 0; $i < $count; $i++) {
            $bot = $this->botService->createBot(
                "Bot_{$type}_{" . uniqid() . "}",
                $type,
                ['created_at' => now()]
            );
            $this->info("Created bot: {$bot->name}");
        }
    }

    private function startBots(): void
    {
        $bots = Bot::where('is_active', true)->get();
        foreach ($bots as $bot) {
            $this->botService->addToQueue($bot);
            $this->info("Added bot to queue: {$bot->name}");
        }
    }

    private function stopBots(): void
    {
        $bots = Bot::where('is_active', true)->get();
        foreach ($bots as $bot) {
            $bot->deactivate();
            $this->info("Stopped bot: {$bot->name}");
        }
    }

    private function showStatus(): void
    {
        $bots = Bot::all();
        $this->table(
            ['ID', 'Name', 'Type', 'Status', 'Last Activity', 'Total Activity'],
            $bots->map(function ($bot) {
                return [
                    $bot->id,
                    $bot->name,
                    $bot->type,
                    $bot->is_active ? 'Active' : 'Inactive',
                    $bot->last_activity ? $bot->last_activity->diffForHumans() : 'Never',
                    $this->botService->getBotActivity($bot->id)
                ];
            })
        );
    }
} 