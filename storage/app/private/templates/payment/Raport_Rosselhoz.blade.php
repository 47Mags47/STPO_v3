<?xml version="1.0" encoding="windows-1251" ?>
<СчетаПК
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:noNamespaceSchemaLocation="Wages.xsd"
    ДатаФормирования="{{ now()->format('Y-m-d') }}"
    НомерДоговора="{{ $contract->number }}"
    ДатаДоговора="{{ $contract->signed_at->format('Y-m-d') }}"
    НаименованиеОрганизации="{{ $config['division']['short_name'] }}"
    ИНН="{{ $config['division']['INN'] }}"
    РасчетныйСчетОрганизации="{{ $config['division']['account'] }}"
    БИК="{{ $config['division']['BIK'] }}"
    ИдПервичногоДокумента="{{ str_pad($npp, 5, '0', STR_PAD_LEFT) }}"
    НомерРеестра="{{ str_pad($npp, 5, '0', STR_PAD_LEFT) }}"
    ДатаРеестра="{{ now()->format('Y-m-d') }}"
>
<ЗачислениеЗарплаты>
@foreach ($recipients as $i => $recipient)
    <Сотрудник Нпп="{{ (int) $i + 1 }}">
        <Фамилия>{{ $recipient->last_name }}</Фамилия>
        <Имя>{{ $recipient->first_name }}</Имя>
        <Отчество>{{ $recipient->middle_name }}</Отчество>
        <ОтделениеБанка></ОтделениеБанка>
        <ЛицевойСчет>{{ $recipient->account }}</ЛицевойСчет>
        <Сумма>{{ $recipient->amount }}</Сумма>
    </Сотрудник>
@endforeach
</ЗачислениеЗарплаты>
<ВидЗачисления>01</ВидЗачисления>
<ПлатежноеПоручение>
    <ДатаПлатежногоПоручения>{{ now()->format('Y-m-d') }}</ДатаПлатежногоПоручения>
    <НазначениеПлатежа>{{ $payment->name }}</НазначениеПлатежа>
    <Ответственный>{{ $config['responsible']['full_name'] }}</Ответственный>
    <Телефон>{{ $config['responsible']['phone'] }}</Телефон>
</ПлатежноеПоручение>
<КонтрольныеСуммы>
    <КоличествоЗаписей>{{ $recipients->count() }}</КоличествоЗаписей>
    <СуммаИтого>{{ $recipients->sum('amount') }}</СуммаИтого>
</КонтрольныеСуммы>
</СчетаПК>
