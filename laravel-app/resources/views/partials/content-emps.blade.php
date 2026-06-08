<!--
    * @package    OilHoldingApp
    * @subpackage Views/Partials
    * @author     Danial1277
    * @version    1.0.0
    * * БЛОК ИНТЕРФЕЙСА:  СПИСОК ПЕРСОНАЛА ДОЧЕРНИХ ПРЕДПРИЯТИЙ (ТАБ "КАДРЫ")
    * * Бизнес-логика:
    * Компонент выводит список сотрудников холдинга. Изначально скрыт (`hidden`).
    * При клике на компанию в сайдбаре, JavaScript убирает заглушку-предупреждение
    * и отображает сетку (Grid) сотрудников, отфильтрованных по `data-employee-company`.
-->

<div id="content-employees" class="tab-content hidden space-y-4">

    <!--
        * ЗАГЛУШКА-УВЕДОМЛЕНИЕ (Alert)
        * Отображается по умолчанию, пока пользователь не кликнул на конкретную компанию.
        * Управляется через JS (`id="select-company-alert"`).
    -->
    <div id="select-company-alert" class="bg-blue-500/5 text-blue-400 p-3 rounded-lg border border-blue-500/10 text-xs">
        Пожалуйста, выберите компанию слева, чтобы увидеть список её сотрудников.
    </div>

    <!--
        * КОНТЕЙНЕР ДЛЯ СЕТКИ КАРТОЧЕК СОТРУДНИКОВ
        * Адаптивная CSS-сетка: 1 колонка на смартфонах, 2 на sm, 3 на md, 4 на больших экранах.
        * Изначально скрыт класс-утилитой `hidden`.
    -->
    <div id="employees-list-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 hidden">

        <!--
            ДВОЙНОЙ ЦИКЛ (ИЕРАРХИЧЕСКИЙ ПЕРЕБОР Мcontent-emps)
            @param \App\Models\Company $company Коллекция всех компаний холдинга
            @param \App\Models\Employee $employee Отношение "Один ко многим" (HasMany)
        -->
        @foreach($companies as $company)
            @foreach($company->employees as $employee)

                <!--
                    * КАРТОЧКА СОТРУДНИКА (Employee Card)
                    * @var data-employee-company Идентификатор компании, критически важный для JS-фильтра
                -->
                <div class="employee-card bg-gray-900 p-3 rounded-lg border border-gray-800 flex items-center space-x-3"
                     data-employee-company="{{ $company->id }}">

                    <!-- Блок для иконки сотрудника (например, SVG-аватар или иконка пользователя) -->
                    <div class="bg-gray-800 p-2 rounded-md text-blue-400 text-sm shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>

                    <!-- Текстовый блок с личными данными сотрудника -->
                    <div class="min-w-0">
                        <!-- ФИО сотрудника холдинга. Класс `truncate` предотвращает перенос и ломание верстки -->
                        <h4 class="font-semibold text-xs text-gray-200 truncate">
                            {{ $employee->first_name }} {{ $employee->last_name }}
                        </h4>
                        <!-- Системный уникальный номер записи в СУБД PostgreSQL -->
                        <p class="text-[10px] text-gray-500 mt-0.5">ID: #{{ $employee->id }}</p>
                    </div>

                </div>
            @endforeach
        @endforeach

    </div>
</div>
