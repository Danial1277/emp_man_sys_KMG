{{--
    * @package    OilHoldingApp
    * @subpackage Views/Partials
    * @author     Danial1277
    * @version    1.0.0
    * * * БЛОК ИНТЕРФЕЙСА:  БОКОВАЯ ПАНЕЛЬ НАВИГАЦИИ ПО ОБЪЕКТАМ ХОЛДИНГА (САЙДБАР)
    * * Бизнес-логика:
    * Панель отображает полный список нефтяных компаний холдинга. Каждая карточка
    * компании содержит её название и счётчик активных скважин. Клик по карточке
    * запускает фронтенд-фильтрацию кадров и производственных графиков.
--}}

<aside class="w-72 bg-gray-900 flex flex-col h-full border-r border-gray-800 select-none">

    {{-- Шапка сайдбара с заголовком и интерактивной кнопкой сброса системного фильтра --}}
    <div class="p-4 border-b border-gray-800 flex justify-between items-center">
        <h2 class="text-sm font-semibold tracking-wider text-gray-400 uppercase"> Компании</h2>

        {{--
            * КНОПКА СБРОСА ФИЛЬТРАЦИИ
            * Изначально скрыта (`hidden`). Показывается силами JavaScript,
            * когда пользователь выбирает любую компанию из списка холдинга.
        --}}
        <button id="reset-filter" class="text-[11px] bg-gray-800 hover:bg-gray-700 text-blue-400 px-2 py-0.5 rounded border border-gray-700 transition hidden">
            Сбросить
        </button>
    </div>

    {{--
        * СКРОЛЛИРУЕМЫЙ БЛОК СПИСКА ПРЕДПРИЯТИЙ
        * Класс `overflow-y-auto` обеспечивает независимую вертикальную прокрутку сайдбара,
        * если список из 22 компаний холдинга превышает высоту экрана монитора.
    --}}
    <div class="flex-1 overflow-y-auto p-3 space-y-1.5 custom-scrollbar">

        {{--
            * ИТЕРАЦИЯ СПИСКА КОМПАНИЙ ХОЛДИНГА
            * @param \Illuminate\Support\Collection|\App\Models\Company[] $companies Коллекция всех структурных компаний
        --}}
        @foreach($companies as $company)

            {{--
                * ИНТЕРАКТИВНАЯ КАРТОЧКА КОМПАНИИ (Company Card)
                * @var data-company-id Системный ID, считываемый JS (`this.getAttribute('data-company-id')`) для запуска фильтрации
            --}}
            <div class="company-card bg-gray-800/40 p-2.5 rounded-lg border border-gray-800 cursor-pointer hover:border-blue-500/50 hover:bg-gray-800 transition duration-150"
                 data-company-id="{{ $company->id }}">

                {{--
                    * ТЕКСТОВЫЙ БЛОК С ДАННЫМИ
                    * `pointer-events-none` полностью отключает реакцию текста на курсор мыши,
                    * чтобы JS-событие клика гарантированно регистрировалось на родительском контейнере `.company-card`.
                --}}
                <h3 class="text-xs font-medium text-gray-300 flex justify-between items-center pointer-events-none">

                    {{-- Название дочернего предприятия холдинга с защитой от слома верстки (`truncate`) --}}
                    <span class="truncate pr-2">{{ $company->name }}</span>

                    {{--
                        * СЧЁТЧИК СКВАЖИН (Badge Counter)
                        * Динамически вычисляет количество буровых скважин, закрепленных за компанией
                        * через стандартный метод агрегации отношений Eloquent.
                    --}}
                    <span class="text-[10px] bg-gray-900 px-1.5 py-0.5 rounded text-gray-500 border border-gray-800/60 shrink-0">
                         {{ $company->wells->count() }}
                    </span>

                </h3>
            </div>
        @endforeach

    </div>
</aside>
