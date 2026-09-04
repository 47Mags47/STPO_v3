START;{{ $event->in_date->format('dmY') }};{{ $npp }};CREDIT;{!! $config['division']['long_name'] !!}
@foreach ($recipients as $recipient)
{{ $recipient->account }};{{ number_format($recipient->amount, 2, ',', '') }};{{ $recipient->last_name }} {{ $recipient->first_name }} {{ $recipient->middle_name }};{{ $recipient->SNILS }};{{ in_array($law->number, ['8-ОЗ', '156-ОЗ']) ? '2' : '3' }};;47;
@endforeach
END;{{ $recipients->count() }};{{ number_format($recipients->sum('amount'), 2, ',', '') }};RUR
