@foreach ($recipients as $recipient)
{{ $recipient->last_name }};{{ $recipient->first_name }};{{ $recipient->middle_name }}
@endforeach
