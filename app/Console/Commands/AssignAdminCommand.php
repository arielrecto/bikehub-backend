<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class AssignAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-admin {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign admin role to the User with the given ID';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = $this->argument('id');

        try {
            $user = User::find($id);

            if ($user) {
                $user->assignRole("admin");
                $this->line($user->email . " now has admin role");
            } else {
                $this->warn("User with ID {$id} not found.");
            }
        } catch (\Exception $e) {
            $this->error("An error occurred: " . $e->getMessage());
        }

        return 0;

    }
}
