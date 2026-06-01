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
        - [x] sfr_fsd_a1_FixPaymentFileResource
            Исправить вывод кол-ва записей на странице payment-files/index

        - [x] sfr_fsd_a2_FixUploadSfrFile
            Исправить загрузку файлов от СФР (ошибка при загрузке больших файлов)

        - [ ] sfr_fsd_a3_AddUploadStatus
            Добавить отображение статуса чтения SFRFile
            Добавить отображение статуса чтения PaymentFile

        - [ ] CreateJobsAlert
            - [ ] Добавить прогресбар чтения FSDFile
            - [ ] Добавить прогресбар чтения PaymentFile

        - [ ] FixTable
            - [ ] Поправить ширину колонки с датами
            - [ ] Добавить заголовок для колонки с датами
            - [ ] Поправить вывод даты на формат xx.xx.xxxx - xx.xx.xxxx

        - [x] sfr_fsd_a1_FixPaymentFileResource
            Исправить вывод кол-ва записей на странице payment-files/index

        - [ ] FixUploadSfrFile
            Исправить загрузку файлов от СФР (ошибка при загрузке больших файлов)

        - [ ] AddErrorHandler
            Добавить валидацию данных из загружаемого файла (SFRFile)
            
- dev ( прочее )
    - pusher ( он же websocket )
        - [x] dev_pusher_a1_InstallAndTest 
            - [x] Установить Larabel/reverb
            - [x] Установить Laravel-echo
            - [x] Установить Pusher-js
            - [x] Создать тестовый event

    - components ( компоненты )
        - [ ] FixIcoButton
            Вынести класс 'ico-button' в отдельный компонент

        - [x] CreateDateInput
            Создать компонент DateInput

        - [x] CreateDateBetweenInput
            Создать компонент DateBetweenInput
        
        - [x] CreateDatePicker
            Создать компонент DatePicker

        - [x] dev_components_a1_CreateErrorPopUp
            Создать компонент высплывающей ошибки

        - [ ] dev_components_a2_CreateContainerAlert
            Ренейм ErrorPopUpQueue на ContainerAlert,
            Рефакт и улучшение кода в компонентах ErrorPopUpMsgm, ErrorPopUpMsgQueue

        - [x] dev_components_CreateNotification

        - [ ] dev_components_CreateDashboard
            - [ ] dev_components_CreateDashBoard_CreateProfile

        - [ ] dev_components_CreateChat
            создать страницу чата

    - libs ( библиотеки, хелперы и тд )
        - [ ] AddDateLib
            - [ ] Добавить глобальный хелпер или библиотеку для форматирования даты

    - base
        - [ ] FixUploadBigFile
            Вынести процесс объеденения чанков (FileChunk) при загрузке больших фалов (UploadFile) в одельный процесс

    - other
        - [ ] FixEmailVerify
            Перенести логику из web.php в контроллер
        - [ ] AddFilters
            добавить фильтры в ResourceTable
        - [ ] add fsdFilesNotifications
            Добавить уведомление при скачивании файла
