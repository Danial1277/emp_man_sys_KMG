<!--
    * @package    OilHoldingApp
    * @subpackage Views/Partials
    * @author     Danial1277
    * @version    1.0.0
    * * * БЛОК ИНТЕРФЕЙСА:  ПРОИЗВОДСТВЕННЫЙ ФОНД СКВАЖИН И ГРАФИКИ ДОБЫЧИ (ТАБ "ДОБЫЧА")
    * * Бизнес-логика:
    * Компонент отвечает за отображение карточек скважин. Внутри каждой карточки
    * инициализируется линейный график суточного дебита жидкости за 365 дней.
    * По умолчанию вкладка видима (`tab-content` без класса `hidden`).
-->

<div id="content-wells" class="tab-content space-y-4">

    <!--
        * АДАПТИВНАЯ СЕТКА КАРТОЧЕК СКВАЖИН (Grid Layout)
        * 1 колонка на мобильных устройствах, 2 колонки на больших экранах (lg)
        * и 3 колонки на ультрашироких мониторах (xli).
    -->
    <div id="wells-grid" class="grid grid-cols-1 lg:grid-cols-2 xli:grid-cols-3 gap-4">

        <!--
            * ИТЕРАЦИЯ ФОНДА СКВАЖИН ХОЛДИНГА
            * @param \Illuminate\Support\Collection|\App\Models\Well[] $analyzedWells Скважины со сгенерированной аналитикой
        -->
        @foreach($analyzedWells as $well)

            <!--
                * КАРТОЧКА СКВАЖИНЫ (Well Chart Card)
                * @var data-well-company Связующий ID компании, используемый JavaScript для фильтрации скважин при клике на сайдбар
            -->
            <div class="well-chart-card bg-gray-900 p-4 rounded-xl border border-gray-800 shadow-md hover:border-gray-700 transition"
                 data-well-company="{{ $well->company_id }}">

                <!-- Верхняя информационная панель карточки: название и имя дочернего предприятия -->
                <div class="flex justify-between items-center mb-3">
                    {{-- Технологический номер или название скважины --}}
                    <h3 class="text-sm font-bold text-gray-200 truncate pr-2"> {{ $well->name }}</h3>

                    <!-- Лейбл с названием родительской компании холдинга -->
                    <span class="text-[10px] bg-blue-500/5 text-blue-400 px-2 py-0.5 rounded border border-blue-500/10 shrink-0">
                        {{ $well->company->name }}
                    </span>
                </div>

                <!--
                    * КОНТЕЙНЕР ДЛЯ ГРАФИКА CHART.JS
                    * Фиксированная высота `h-48` обеспечивает корректную работу опции maintainAspectRatio: false.
                -->
                <div class="h-48 w-full">
                    <!--
                        * Элемент Canvas для отрисовки графика.
                        * @var id Уникальный идентификатор холста для JS-конструктора.
                        * @var data-labels Массив дат (365 дней), извлеченный через Eloquent Pluck и упакованный в JSON-строку.
                        * @var data-values Массив числовых дебитов жидкости ($m^3/сут$) для оси ординат.
                    -->
                    <canvas id="chart-{{ $well->id }}"
                            data-labels="{{ json_encode($well->dailyProductions->pluck('date')) }}"
                            data-values="{{ json_encode($well->dailyProductions->pluck('production_value')) }}">
                    </canvas>
                </div>

            </div>
        @endforeach
    </div>

    <!--
        * СИСТЕМНОЕ СЛУЖЕБНОЕ УВЕДОМЛЕНИЕ (Alert)
        * Изначально скрыто (`hidden`). Активируется силами JS (`id="no-data-alert"`),
        * если у выбранной в сайдбаре нефтяной компании физически нет привязанных скважин.
    -->
    <div id="no-data-alert" class="hidden bg-gray-900 p-6 rounded-xl border border-gray-800 text-center text-xs text-gray-500">
        Для этой компании не сгенерированы показатели добычи.
    </div>

</div>
