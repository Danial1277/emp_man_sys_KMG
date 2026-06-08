<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Well;
use Illuminate\Contracts\View\View;

/**
 * Контроллер для обработки и вывода аналитических данных на Дашборд.
 */
class DashboardController extends Controller
{
    /**
     * Отображает главную страницу мониторинга производства.
     * * Загружает жадной загрузкой (Eager Loading) компании, связи сотрудников
     * и суточные показатели добычи (ограничивая выборку первыми скважинами с графиками).
     *
     * @return View Возвращает Blade-шаблон 'dashboard' с массивом данных
     */
    public function index(): View
    {
        // Загружаем компании с их структурой для сайдбара и вкладок
        $companies = Company::with(['wells', 'employees'])->get();

        // Загружаем только те скважины, у которых сгенерирована аналитика (первые 5 по ТЗ)
        $analyzedWells = Well::whereHas('dailyProductions')
            ->with(['company', 'dailyProductions' => function($query) {
                $query->orderBy('date', 'asc');
            }])->get();

        return view('dashboard', compact('companies', 'analyzedWells'));
    }
}
