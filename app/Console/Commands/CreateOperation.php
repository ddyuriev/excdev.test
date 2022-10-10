<?php

namespace App\Console\Commands;

use App\Jobs\CreateOperationJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateOperation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-operation {login} {value} {description} {uuid}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create-operation command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $fields = [
            'login' => $this->argument('login'),
            'value' => $this->argument('value'),
            'description' => $this->argument('description'),
            'uuid' => $this->argument('uuid'),
        ];
        $validator = Validator::make($fields, [
            'login' => 'required|email|exists:users,email',
            'value' => 'required|numeric',
            'description' => 'required|string',
            'uuid' => 'required|uuid|unique:operations,uuid',
        ]);
        if ($validator->fails()) {
            print_r($validator->errors()->all());
            return 0;
        }

        dispatch(new CreateOperationJob($fields));

        return 0;
    }
}
