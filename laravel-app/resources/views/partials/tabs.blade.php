{{--
    * @package    OilHoldingApp
    * @subpackage Views/Partials
    * @author     Danial1277
    * @version    1.0.0
    * * * БЛОК ИНТЕРФЕЙСА:  ПАНЕЛЬ ИНТЕРАКТИВНОГО ПЕРЕКЛЮЧЕНИЯ ВКЛАДОК (ТАБЫ ДАШБОРДА)
    * * Бизнес-логика:
    * Компонент предоставляет пользователю переключатели между технологическими
    * показателями (производственный фонд скважин) и кадровой структурой (персонал).
    * Стили кнопок динамически модифицируются скриптом `dashboard.js` путём
    * добавления/удаления классов активности Tailwind CSS.
--}}

<div class="flex space-x-2 text-xs">

    {{--
        * КНОПКА: ТАБ "СКВАЖИНЫ И ГРАФИКИ"
        * По умолчанию является АКТИВНОЙ при загрузке дашборда холдинга.
        * Имеет синий индикатор подчеркивания (`text-blue-400 border-blue-400`).
        * @var id tab-wells Используется в JS-слушателе событий для отображения блока #content-wells
    --}}
    <button id="tab-wells" class="tab-btn px-3 py-2 font-medium text-blue-400 border-b-2 border-blue-400 focus:outline-none transition">
        Скважины и Графики
    </button>

    {{--
        * КНОПКА: ТАБ "СОТРУДНИКИ КОМПАНИИ"
        * По умолчанию является НЕАКТИВНОЙ при загрузке дашборда холдинга.
        * Имеет прозрачную нижнюю рамку (`border-transparent`) и серый цвет текста.
        * @var id tab-employees Используется в JS-слушателе событий для отображения блока #content-employees
    --}}
    <button id="tab-employees" class="tab-btn px-3 py-2 font-medium text-gray-400 hover:text-gray-200 border-b-2 border-transparent focus:outline-none transition">
        Сотрудники Компании
    </button>

</div>
