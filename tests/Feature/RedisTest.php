<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Redis;

class RedisTest extends TestCase
{
    public function test_redis_connection()
    {
        $isConnected = Redis::connection()->ping();
        $this->assertTrue($isConnected == 'PONG');
    }

    public function test_redis_operations()
    {
        // Test String
        Redis::set('test_key', 'test_value');
        $this->assertEquals('test_value', Redis::get('test_key'));

        // Test List
        Redis::del('test_list'); // Clear previous data
        Redis::lpush('test_list', 'item1');
        Redis::lpush('test_list', 'item2');
        $this->assertEquals(['item2', 'item1'], Redis::lrange('test_list', 0, -1));

        // Test Hash
        Redis::del('test_hash'); // Clear previous data
        Redis::hset('test_hash', 'field1', 'value1');
        $this->assertEquals('value1', Redis::hget('test_hash', 'field1'));

        // Test Set
        Redis::del('test_set'); // Clear previous data
        Redis::sadd('test_set', 'member1');
        Redis::sadd('test_set', 'member2');
        $this->assertTrue(Redis::sismember('test_set', 'member1'));

        // Test Increment
        Redis::del('test_counter'); // Clear previous data
        Redis::incr('test_counter');
        Redis::incr('test_counter');
        $this->assertEquals(2, Redis::get('test_counter'));
    }
} 