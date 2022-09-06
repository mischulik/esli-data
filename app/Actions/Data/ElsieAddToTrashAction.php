<?php

namespace App\Actions\Data;

use Illuminate\Console\Command;
use Lorisleiva\Actions\Concerns\AsAction;

class ElsieAddToTrashAction
{
    use AsAction;

    public string $commandSignature = 'elsie:add {json}';

    public function handle()
    {
        // ...
    }

    public function asCommand(Command $command)
    {
        dd($command->argument('json'));
    }
}
