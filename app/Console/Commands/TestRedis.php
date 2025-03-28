<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class TestRedis extends Command
{
    protected $signature = 'redis:test';
    protected $description = 'Test Redis connection and operations';

    public function handle()
    {
        $this->info('Testing Redis connection...');

        try {
            // Test connection
            $ping = Redis::connection()->ping();
            $this->info("Connection test: " . ($ping == 'PONG' ? 'SUCCESS' : 'FAILED'));

            // Test string
            Redis::set('test_string', 'Hello Redis!');
            $this->info("String test: " . Redis::get('test_string'));

            // Test list
            Redis::del('test_list');
            Redis::lpush('test_list', 'item1');
            Redis::lpush('test_list', 'item2');
            $this->info("List test: " . implode(', ', Redis::lrange('test_list', 0, -1)));

            // Test hash
            Redis::del('test_hash');
            Redis::hset('test_hash', 'name', 'John');
            Redis::hset('test_hash', 'age', '30');
            $this->info("Hash test: " . json_encode(Redis::hgetall('test_hash')));

            // Test set
            Redis::del('test_set');
            Redis::sadd('test_set', 'unique1');
            Redis::sadd('test_set', 'unique2');
            Redis::sadd('test_set', 'unique1'); // Дубликат не добавится
            $this->info("Set test: " . implode(', ', Redis::smembers('test_set')));

            // Test increment
            Redis::del('test_counter');
            Redis::incr('test_counter');
            Redis::incr('test_counter');
            $this->info("Counter test: " . Redis::get('test_counter'));

            $this->info('All Redis tests completed successfully!');
        } catch (\Exception $e) {
            $this->error('Redis test failed: ' . $e->getMessage());
        }
    }
} 