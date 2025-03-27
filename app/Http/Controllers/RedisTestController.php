<?php

namespace App\Http\Controllers;

use App\Services\RedisService;
use Illuminate\Http\JsonResponse;

class RedisTestController extends Controller
{
    private $redisService;

    public function __construct(RedisService $redisService)
    {
        $this->redisService = $redisService;
    }

    public function test(): JsonResponse
    {
        // Тест простых значений
        $this->redisService->setSimpleValue('test_key', 'Hello Redis!', 3600);
        $simpleValue = $this->redisService->getSimpleValue('test_key');

        // Тест списков
        $this->redisService->addToList('test_list', 'item1');
        $this->redisService->addToList('test_list', 'item2');
        $list = $this->redisService->getList('test_list');

        // Тест хэшей
        $this->redisService->setHash('test_hash', [
            'name' => 'John',
            'age' => '30'
        ]);
        $hash = $this->redisService->getHash('test_hash');

        // Тест сетов
        $this->redisService->addToSet('test_set', 'unique1');
        $this->redisService->addToSet('test_set', 'unique2');
        $this->redisService->addToSet('test_set', 'unique1'); // Дубликат не добавится
        $set = $this->redisService->getSet('test_set');

        // Тест счетчика
        $counter = $this->redisService->increment('test_counter');

        return response()->json([
            'simple_value' => $simpleValue,
            'list' => $list,
            'hash' => $hash,
            'set' => $set,
            'counter' => $counter
        ]);
    }
} 