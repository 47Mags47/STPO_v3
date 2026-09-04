5555746{!! str_pad($recipients->sum('amount'), 15, ' ', STR_PAD_LEFT) !!}z
@foreach ($recipients as $recipient)
{!! mb_str_pad($recipient->last_name, 20, ' ') !!}{!! mb_str_pad($recipient->first_name, 20, ' ') !!}{!! mb_str_pad($recipient->middle_name, 20, ' ') !!}{!! $recipient->account !!}{!! mb_str_pad($recipient->amount, 12, ' ', STR_PAD_LEFT) !!}10        0.002
@endforeach
