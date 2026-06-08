<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeDataCommand extends Command
{
    /**
     * Имя и сигнатура консольной команды.
     */
    protected $signature = 'make:data';

    /**
     * Описание консольной команды.
     */
    protected $description = 'Наполнение базы данных реалистичной аналитикой через Сидеры';

    /**
     * Выполнение команды.
     */
    public function handle(): int
    {
        $this->info('Запуск генерации данных через DatabaseSeeder...');

        // Вызываем сидер прямо из консольной команды!
        $this->call('db:seed', ['--class' => 'DatabaseSeeder']);

        $this->info('Данные успешно сгенерированы!');
        return Command::SUCCESS;
    }
}
