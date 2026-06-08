<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Класс-модель для работы с нефтегазовыми скважинами.
 * * @property int $id Уникальный идентификатор скважины
 * @property int $company_id ID добывающей компании
 * @property string $name Название или номер скважины
 * @property-read \App\Models\Company $company Объект связанной компании
 */
class Well extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'name'];

    /**
     * Получить компанию, которой принадлежит данная скважина.
     * * @return BelongsTo
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Получить историю суточных показателей добычи скважины.
     * * @return HasMany
     */
    public function dailyProductions(): HasMany
    {
        return $this->hasMany(DailyProduction::class);
    }

    /**
     * Расчет технологических показателей скважины (Бизнес-логика).
     * * Формула дебита жидкости (Q_ж) и чистой нефти (Q_н):
     * 1. Q_ж = $baseProduction (базовое значение из БД) * Коэффициент эффективности.
     * 2. Q_н = Q_ж * (1 - W / 100), где W — процент обводненности продукции.
     *
     * @param float $baseProduction Текущее значение суточной добычи из БД (м³/сут)
     * @param float $waterCut Процент обводненности скважины (например, 15.5%)
     * @return array{liquid_rate: float, oil_rate: float} Дебиты жидкости и чистой нефти
     */
    public function calculateOilRates(float $baseProduction, float $waterCut = 20.0): array
    {
        // Предположим, технологический коэффициент оборудования = 1.05
        $efficiencyCoefficient = 1.05;

        // Расчет дебита жидкости
        $liquidRate = $baseProduction * $efficiencyCoefficient;

        // Расчет дебита чистой нефти за вычетом пластовой воды
        $oilRate = $liquidRate * (1 - ($waterCut / 100));

        return [
            'liquid_rate' => round($liquidRate, 2),
            'oil_rate' => round($oilRate, 2)
        ];
    }
}
