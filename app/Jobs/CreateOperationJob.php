<?php

namespace App\Jobs;

use App\Models\Balance;
use App\Models\Operation;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CreateOperationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $params;

    /**
     * CreateOperationJob constructor.
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $balance = Balance::where('user_id', User::where('email', $this->params['login'])->first()->id)->first();

        if ($balance->balance + $this->params['value'] < 0) {
            Log::warning('write-off exceeds the balance', $this->params);
            return;
        }

        DB::transaction(function () use ($balance) {
            Operation::create(
                [
                    'balance_id' => $balance->id,
                    'uuid' => $this->params['uuid'],
                    'value' => $this->params['value'],
                    'description' => $this->params['description'],
                ]
            );

            $balance->balance += $this->params['value'];
            $balance->save();
        });
    }
}
