{{--
    * @package    OilHoldingApp
    * @subpackage Views
    * @author     Danial1277
    * @version    1.0.0
    * * * ГЛАВНЫЙ ШАБЛОН:  ЦЕНТРАЛЬНАЯ КОНСОЛЬ МОНИТОРИНГА ХОЛДИНГА (DASHBOARD)
    * * Бизнес-логика:
    * Является корневой точкой входа для интерфейса аналитики. Объединяет боковую панель
    * навигации, шапку управления, переключатели вкладок и динамические контентные зоны
    * (модули скважин холдинга и кадров дочерних предприятий).
--}}

    <!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Дашборд Аналитики Скважин — Холдинг КМГ</title>

    {{-- Подключение компилятора Tailwind CSS для генерации стилей "на лету" --}}
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    {{--
        * ДИРЕКТИВА VITE
        * Автоматически собирает и подключает ассеты приложения (CSS и JS-логику табов/графиков).
    --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-900 text-gray-100 font-sans antialiased h-screen overflow-hidden">

{{-- Основной полноэкранный каркас приложения (Flex-контейнер) --}}
<div class="flex h-full w-full">

    {{--
        * КОМПОНЕНТ: БОКОВАЯ ПАНЕЛЬ НАВИГАЦИИ (Сайдбар)
        * @include Выводит список 22 нефтедобывающих компаний холдинга
    --}}
    @include('partials.sidebar')

    {{-- Главная рабочая область дашборда (Контентная правая часть) --}}
    <main class="flex-1 flex flex-col min-w-0 h-full bg-gray-950">

        {{-- ВЕРХНЯЯ ПАНЕЛЬ (Header) — Отображает текущий контекст мониторинга --}}
        <header class="border-b border-gray-800 px-6 py-3 flex justify-between items-center bg-gray-900/50 backdrop-blur">
            <div>
                {{--
                    * ЗАГЛУШКА ЗАГОЛОВКА ДАШБОРДА
                    * @var id dashboard-title Модифицируется силами JavaScript при выборе компании из сайдбара
                --}}
                <h1 id="dashboard-title" class="text-xl font-bold tracking-tight text-white flex items-center gap-2">
                    Мониторинг Производства
                </h1>
            </div>
        </header>

        {{-- БЛОК НАВИГАЦИОННЫХ ВКЛАДОК (Вкладки управления данными) --}}
        <div class="px-6 pt-2 bg-gray-900/20 border-b border-gray-800">
            {{-- @include Подключает кнопки переключения "Скважины" / "Сотрудники" --}}
            @include('partials.tabs')
        </div>

        {{--
            * ДИНАМИЧЕСКИЙ КОНТЕНТНЫЙ БЛОК (Скроллируемый контейнер)
            * Здесь выводятся целевые данные. Скрытие/отображение регулируется классами утилит.
        --}}
        <div class="flex-1 overflow-y-auto p-6 space-y-6">

            {{--
                * КОМПОНЕНТ: ТЕХНОЛОГИЧЕСКИЕ ПОКАЗАТЕЛИ (Фонд скважин и графики добычи)
                * Видим по умолчанию при загрузке страницы дашборда.
            --}}
            @include('partials.content-wells')

            {{--
                * КОМПОНЕНТ: КАДРОВАЯ СТРУКТУРА (Список сотрудников выбранного предприятия)
                * По умолчанию скрыт внутри партиала через класс `hidden`.
            --}}
            @include('partials.content-emps')

        </div>
    </main>
</div>

</body>
</html>
