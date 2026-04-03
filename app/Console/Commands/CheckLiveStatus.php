<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Live;
use App\Models\User;
use App\Mail\LiveStartedMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class CheckLiveStatus extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'lives:check-started';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Check scheduled lives that are starting and send email notifications to followers/users.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info("Checking for starting lives at " . Carbon::now());

        // Select lives scheduled for now or earlier that haven't been processed yet
        $startingLives = Live::where('status', 'scheduled')
            ->where('started_at', '<=', Carbon::now())
            ->get();

        if ($startingLives->isEmpty()) {
            $this->info("No lives starting at this time.");
            return;
        }

        foreach ($startingLives as $live) {
            $this->info("Processing live: " . $live->title . " by " . $live->user->name);
            
            // Mark as online/live
            $live->status = 'online';
            $live->save();

            // Send notification to all users (mocking subscribers for now)
            // In a real app, this would use a 'followers' relationship: $live->user->followers
            $recipients = User::all();

            foreach ($recipients as $user) {
                try {
                    Mail::to($user->email)->queue(new LiveStartedMail($live));
                    $this->debug("Email queued for " . $user->email);
                } catch (\Exception $e) {
                    $this->error("Failed to queue email for " . $user->email . ": " . $e->getMessage());
                }
            }
        }

        $this->info("Completed processing " . $startingLives->count() . " lives.");
    }
}
