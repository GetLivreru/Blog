<?php

namespace App\Services;

use App\Models\Bot;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class BotService
{
    private const QUEUE_KEY = 'bot:queue';
    private const ACTIVITY_KEY = 'bot:activity';

    public function createBot(string $name, string $type, array $settings = []): Bot
    {
        return Bot::create([
            'name' => $name,
            'type' => $type,
            'settings' => $settings,
            'is_active' => true
        ]);
    }

    public function simulateActivity(Bot $bot): void
    {
        // Добавляем активность в Redis для мониторинга
        Redis::hincrby(self::ACTIVITY_KEY, $bot->id, 1);
        
        // Обновляем время последней активности
        $bot->updateActivity();

        // Симулируем случайную задержку
        sleep(rand(1, 5));
    }

    public function addToQueue(Bot $bot): void
    {
        Redis::lpush(self::QUEUE_KEY, json_encode([
            'bot_id' => $bot->id,
            'timestamp' => now()->timestamp
        ]));
    }

    public function processQueue(): void
    {
        while ($data = Redis::rpop(self::QUEUE_KEY)) {
            $data = json_decode($data, true);
            $bot = Bot::find($data['bot_id']);

            if ($bot && $bot->isActive()) {
                $this->simulateActivity($bot);
            }
        }
    }

    public function getBotActivity(int $botId): int
    {
        return (int) Redis::hget(self::ACTIVITY_KEY, $botId);
    }

    public function getAllBotActivity(): array
    {
        return Redis::hgetall(self::ACTIVITY_KEY);
    }

    public function clearActivity(): void
    {
        Redis::del(self::ACTIVITY_KEY);
    }
} 