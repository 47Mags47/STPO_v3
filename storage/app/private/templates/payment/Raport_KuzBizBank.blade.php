@foreach ($recipients as $i => $recipient)
{{ $i + 1 }};{{ $recipient->last_name }} {{ $recipient->first_name }} {{ $recipient->middle_name }};{{ $recipient->d_rojd->format('d/m/Y') }};8;{{ $recipient->p_series[0] }}{{ $recipient->p_series[1] }} {{ $recipient->p_series[2] }}{{ $recipient->p_series[3] }};{{ $recipient->p_number }};{{ $recipient->p_date->format('d/m/Y') }};{{ $recipient->p_div }};{{ $recipient->account }};{{ $recipient->amount }};
@endforeach
