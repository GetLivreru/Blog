<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;

class RedisService
{
    /**
     * Пример сохранения простого значения
     */
    public function setSimpleValue(string $key, string $value, int $ttl = null)
    {
        if ($ttl) {
            Redis::setex($key, $ttl, $value);
        } else {
            Redis::set($key, $value);
        }
    }

    /**
     * Пример получения простого значения
     */
    public function getSimpleValue(string $key)
    {
        return Redis::get($key);
    }

    /**
     * Пример работы со списками
     */
    public function addToList(string $listKey, string $value)
    {
        Redis::rpush($listKey, $value);
    }

    /**
     * Получить весь список
     */
    public function getList(string $listKey)
    {
        return Redis::lrange($listKey, 0, -1);
    }

    /**
     * Пример работы с хэшами
     */
    public function setHash(string $hashKey, array $data)
    {
        Redis::hmset($hashKey, $data);
    }

    /**
     * Получить значение хэша
     */
    public function getHash(string $hashKey)
    {
        return Redis::hgetall($hashKey);
    }

    /**
     * Пример работы с сетами (уникальными значениями)
     */
    public function addToSet(string $setKey, string $value)
    {
        Redis::sadd($setKey, $value);
    }

    /**
     * Получить все значения сета
     */
    public function getSet(string $setKey)
    {
        return Redis::smembers($setKey);
    }

    /**
     * Увеличить счетчик
     */
    public function increment(string $key)
    {
        return Redis::incr($key);
    }

    /**
     * Проверить существование ключа
     */
    public function exists(string $key)
    {
        return Redis::exists($key);
    }
} 