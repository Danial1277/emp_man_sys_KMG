/**
 * @fileoverview Скрипт управления интерактивным дашбордом нефтяного холдинга.
 * Обеспечивает отрисовку графиков дебита через Chart.js, переключение вкладок (кадры/добыча)
 * и динамическую фронтенд-фильтрацию объектов по выбранной компании.
 * * @author Danial1277
 * @version 1.0.0
 */

import Chart from 'chart.js/auto'; // Импортируем Chart.js, если сборка идет через Vite

document.addEventListener('DOMContentLoaded', function () {

    /**
     * @type {string|null} Хранилище ID текущей выбранной пользователем компании для фильтрации
     */
    let activeCompanyId = null;



    //  1. АВТОМАТИЧЕСКАЯ ОТРИСОВКА ГРАФИКОВ ДОБЫЧИ СКВАЖИН (Chart.js)


    /**
     * Находим все элементы canvas, ID которых начинается с "chart-" (сгенерированные Blade)
     * @type {NodeListOf<HTMLCanvasElement>}
     */
    const canvases = document.querySelectorAll('canvas[id^="chart-"]');

    canvases.forEach(canvas => {
        /**
         * Извлекаем массивы дат и значений дебита, которые Blade зашил в HTML-атрибуты.
         * JSON.parse превращает строку '[...]' обратно в массив JavaScript.
         */
        const labels = JSON.parse(canvas.getAttribute('data-labels') || '[]');
        const dataValues = JSON.parse(canvas.getAttribute('data-values') || '[]');

        /** Инициализация линейного графика дебита жидкости (м³ / сут) за 365 дней */
        new Chart(canvas, {
            type: 'line',
            data: {
                labels: labels, // Ось X (Даты замеров)
                datasets: [{
                    label: 'м³ / сут',
                    data: dataValues, // Ось Y (Объем добычи)
                    borderColor: 'rgb(7, 100, 240)',     // Премиальный синий цвет линии
                    backgroundColor: 'rgba(52, 211, 153, 0.05)', // Легкая заливка под графиком
                    borderWidth: 2,
                    pointRadius: 0, // Скрываем точки на графике для плавной линии (365 дней)
                    tension: 0.2    // Степень сглаживания изгибов линии
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false } // Отключаем легенду, так как у нас один датасет
                }
            }
        });
    });



    //  2. УПРАВЛЕНИЕ ИНТЕРАКТИВНЫМИ ВКЛАДКАМИ (ТАБАМИ)


    const tabWells = document.getElementById('tab-wells');
    const tabEmployees = document.getElementById('tab-employees');
    const contentWells = document.getElementById('content-wells');
    const contentEmployees = document.getElementById('content-employees');

    if (tabWells && tabEmployees) {
        /**
         * Универсальная функция для переключения активного таба
         * @param {HTMLElement} activeTab Кнопка таба, которую активируем
         * @param {HTMLElement} activeContent Блок с контентом, который нужно показать
         * @param {HTMLElement} inactiveTab Кнопка таба, которую нужно деактивировать
         * @param {HTMLElement} inactiveContent Блок с контентом, который нужно скрыть
         */
        function switchTab(activeTab, activeContent, inactiveTab, inactiveContent) {
            // Стилизуем активную вкладку под Tailwind синий цвет
            activeTab.classList.add('text-blue-400', 'border-blue-400');
            inactiveTab.classList.remove('text-blue-400', 'border-blue-400');
            inactiveTab.classList.add('text-gray-400');

            // Управляем видимостью контента (убираем/добавляем класс utility-класс hidden)
            activeContent.classList.remove('hidden');
            inactiveContent.classList.add('hidden');
        }

        /** Навешиваем обработчики событий клика на вкладки */
        tabWells.addEventListener('click', () => switchTab(tabWells, contentWells, tabEmployees, contentEmployees));
        tabEmployees.addEventListener('click', () => switchTab(tabEmployees, contentEmployees, tabWells, contentWells));
    }



    //  3. ДИНАМИЧЕСКАЯ ФИЛЬТРАЦИЯ ОБЪЕКТОВ ХОЛДИНГА ПО КЛИКУ


    /** DOM-элементы карточек компаний, графиков скважин и списков сотрудников */
    const companyCards = document.querySelectorAll('.company-card');
    const wellCards = document.querySelectorAll('.well-chart-card');
    const employeeCards = document.querySelectorAll('.employee-card');

    /** Элементы интерфейса состояния фильтрации */
    const resetBtn = document.getElementById('reset-filter');
    const noDataAlert = document.getElementById('no-data-alert');
    const selectCompanyAlert = document.getElementById('select-company-alert');
    const employeesListContainer = document.getElementById('employees-list-container');
    const title = document.getElementById('dashboard-title');

    companyCards.forEach(card => {
        /** При клике на карточку нефтяной компании срабатывает локальный фильтр */
        card.addEventListener('click', function() {
            activeCompanyId = this.getAttribute('data-company-id');
            const companyName = this.querySelector('h3 span').innerText;

            // Визуально подсвечиваем активную карточку компании border-линзой
            companyCards.forEach(c => c.classList.remove('border-blue-500', 'bg-gray-700'));
            this.classList.add('border-blue-500', 'bg-gray-700');

            // Активируем кнопку сброса и меняем заголовок панели на название компании
            if (resetBtn) resetBtn.classList.remove('hidden');
            if (title) title.innerText = ` Панель: ${companyName}`;

            /** Перебор карточек скважин: скрываем чужие, показываем подходящие */
            let visibleCharts = 0;
            wellCards.forEach(w => {
                const match = w.getAttribute('data-well-company') === activeCompanyId;
                w.classList.toggle('hidden', !match);
                if(match) visibleCharts++;
            });

            // Если у компании нет скважин — выводим сообщение «Данные отсутствуют»
            if (noDataAlert) noDataAlert.classList.toggle('hidden', visibleCharts > 0);

            // Переключаем интерфейс сотрудников: убираем заглушку, показываем список
            if (selectCompanyAlert) selectCompanyAlert.classList.add('hidden');
            if (employeesListContainer) employeesListContainer.classList.remove('hidden');

            // Скрываем или отображаем карточки сотрудников на основе ID компании
            employeeCards.forEach(e => e.classList.toggle('hidden', e.getAttribute('data-employee-company') !== activeCompanyId));
        });
    });



    // 4. ЛОГИКА СБРОСА ВСЕХ СИСТЕМНЫХ ФИЛЬТРОВ

    if (resetBtn) {
        /** Возвращаем интерфейс дашборда в исходное (глобальное) состояние */
        resetBtn.addEventListener('click', function() {
            // Очищаем подсветку с карточек компаний
            companyCards.forEach(c => c.classList.remove('border-blue-500', 'bg-gray-700'));

            // Показываем абсолютно все скважины и сотрудников холдинга обратно
            wellCards.forEach(w => w.wl = w.classList.remove('hidden'));
            employeeCards.forEach(e => e.classList.remove('hidden'));

            // Восстанавливаем дефолтное состояние системных алертов и заглушек
            if (noDataAlert) noDataAlert.classList.add('hidden');
            if (selectCompanyAlert) selectCompanyAlert.classList.remove('hidden');
            if (employeesListContainer) employeesListContainer.classList.add('hidden');

            // Возвращаем стандартный заголовок мониторинга и прячем кнопку сброса
            if (title) title.innerText = ' Мониторинг Производства';
            this.classList.add('hidden');
        });
    }
});
