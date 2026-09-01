<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\EventStoreRequest;
use App\Http\Requests\Payment\EventUpdateRequest;
use App\Models\Administrate\Payment;
use App\Models\Payment\Event;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $date_start = CarbonImmutable::create(
            $request->year ?? now()->format('Y'),
            $request->month ?? now()->format('m'),
        );

        $date_end = $date_start->endOfMonth();

        $events = Event::whereBetween('in_date', [$date_start, $date_end])
            ->orderBy('in_date')
            ->paginate();

        return Inertia::render('payment/events/index', [
            'events' => fn() => $events->toResourceCollection(),
            'current_date' => $date_start
        ]);
    }

    public function create()
    {
        return Inertia::render('payment/events/create', [
            'payments' => fn() => Payment::all()->toResourceCollection(),
        ]);
    }

    public function store(EventStoreRequest $request)
    {
        Event::create($request->validated());

        return redirect()->route('payment.events.index')->with('success', 'Запись успешно создана');
    }

    public function edit(Event $event)
    {
        return Inertia::render('payment/events/edit', [
            'event'     => fn() => $event->toResource(),
            'payments'  => fn() => Payment::all()->toResourceCollection(),
        ]);
    }

    public function update(EventUpdateRequest $request, Event $event)
    {
        $event->update($request->validated());

        return redirect()->route('payment.events.index')->with('success', 'Запись успешно обновлена');
    }

    public function delete(Event $event)
    {
        $event->delete();

        return redirect()->route('payment.events.index')->with('success', 'Запись удалена');
    }
}
