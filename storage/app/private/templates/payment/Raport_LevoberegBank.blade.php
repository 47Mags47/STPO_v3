00,0000{{ $event->in_date->format('d.m.Y') }},{{ $recipients->count() }},{{ $recipients->sum('amount') }}
@foreach ($recipients as $i => $recipient)
{{ $i + 1 }},,{{ $recipient->last_name }},{{ $recipient->first_name }},{{ $recipient->middle_name }},{{ $recipient->account }},{{ $recipient->amount }}
@endforeach
