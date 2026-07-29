<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Jobs\Payment\WriteArchiveJob;
use App\Models\Base\File;
use App\Models\Payment\Archive;
use App\Models\Payment\Event;
use Inertia\Inertia;

class ArchiveController extends Controller
{
    public function index(Event $event)
    {
        return Inertia::render('payment/archives/index', [
            'files' => fn() => $event->archives->toResourceCollection(),
            'event' => fn() => $event->toResource(),
        ]);
    }

    public function store(Event $event){
        $archive = File::createChildren(Archive::class, [
            'event_id' => $event->id,
            'origin_name' => 'Отчет по ' . $event->payment->code .'.zip',
        ]);

        WriteArchiveJob::dispatch($archive);

        return redirect()->route('payment.archives.index', ['event' => $event->id])->with('success', 'Запущено формирование файла');
    }

    public function show(Event $event, Archive $archive) {
        return $archive->download();
    }
}
