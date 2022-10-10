<?php

namespace App\Console\Commands;

use App\Models\Balance;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-user {name} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create user command';

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
            'name' => $this->argument('name'),
            'email' => $this->argument('email'),
            'password' => $this->argument('password'),
        ];
        $validator = Validator::make($fields, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string'
        ]);
        if ($validator->fails()) {
            print_r($validator->errors()->all());
            return 0;
        }

        $fields['password'] = Hash::make($fields['password']);
        $user = User::create($fields);

        Balance::create([
            'user_id' => $user->id,
            'balance' => 0,
        ]);

        $response = [
            'user' => $user->toArray(),
        ];
        print_r($response);

        return 0;
    }
}
