- administrate ( Администрирование системы )
    - divisions     Организации
    - moduls        модули системы, навигация
    - templates     Шаблоны
    - permissions   Права и разрешения пользователей

- Appeals ( Обращения )
    - [ ] CreateAppealPages
        - [ ] Создать страницу appeals/index    таблица ресурса
        - [ ] Создать страницу appeals/create   форма ресурса
            office      number      если человек работает в Минтруде или ЦСВИ
            them_id     select      ID темы обращения
            comment     textarea    краткое содержание вопроса
            files       files       файлы - вложения

        - [ ] Создать страницу messages/index   аля чат
        - [ ] Создать страницу messages/create  форма ресурса
            message     string/textarea     текст сообщения
            files       files               файлы - вложения

        - [ ] Создать страницу them-groups/index    таблица ресурса
        - [ ] Создать страницу them-groups/create   форма ресурса
            name        string      Наименование группы
        - [ ] Создать страницу them-groups/edit     форма ресурса
            name        string      Наименование группы

        - [ ] Создать страницу thems/index    таблица ресурса
        - [ ] Создать страницу thems/create   форма ресурса
            group_id    select      ID группы
            name        string      Наименование темы
        - [ ] Создать страницу thems/edit     форма ресурса
            group_id    select      ID группы
            name        string      Наименование темы

- sfr ( Он же FSD ) ( СФР )
    - fsd   Федеральная Социальная Доплата
        - [ ] CreateJobsAlert
            - [ ] Добавить прогресбар чтения FSDFile
            - [ ] Добавить прогресбар чтения PaymentFile

        - [ ] FixTable
            - [ ] Поправить ширину колонки с датами
            - [ ] Добавить заголовок для колонки с датами
            - [ ] Поправить вывод даты на формат xx.xx.xxxx - xx.xx.xxxx

        - [x] sfr_fsd_a1_FixPaymentFileResource
            Исправить вывод кол-ва записей на странице payment-files/index

- dev ( прочее )
    - pusher ( он же websocket )
        - [ ] dev_pusher_a1_InstallAndTest 
            - [ ] Установить пушер

    - components ( компоненты )
        - [ ] FixIcoButton
            - [ ] Вынести класс 'ico-button' в отдельный компонент

        - [ ] CreateDateInput
            - [ ] Создать компонент DateInput

        - [ ] CreateDateBetweenInput
            - [ ] Создать компонент DateBetweenInput

    - libs ( библиотеки, хелперы и тд )
        - [ ] AddDateLib
            - [ ] Добавить глобальный хелпер или библиотеку для форматирования даты
