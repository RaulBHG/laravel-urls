<?php

namespace App\Logging\LogDb;

use Monolog\Logger;

class DatabaseLogger
{
    public function __invoke(array $config): Logger
    {
        return new Logger('Database', [
            new DatabaseHandler($config['level'] ?? 'debug'),
        ]);
    }

}
