<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Activity;
use App\User;

class CronForGuests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'guests:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete every post and activity by guest users once a day.';

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
     * @return mixed
     */
    public function handle()
    {
        echo Activity::leftJoin('users', 'activities.user_id', '=', 'users.id')->where('users.role', '=', '1')->delete();
    }
}
