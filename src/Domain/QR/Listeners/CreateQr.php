<?php

namespace Domain\QR\Listeners;

use Illuminate\Support\Facades\Log;
use Statamic\Events\EntryCreated;

class CreateQr
{
    public function handle(EntryCreated $entry): void
    {
        Log::debug('Listener CreateQr::handle', [
            'entry' => $entry->entry,
        ]);
    }
}
