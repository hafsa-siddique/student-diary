<?php

namespace App\Console\Commands;

use App\Models\DiaryEntry;
use Illuminate\Console\Command;

class PublishScheduledDiaries extends Command
{
    // The name and signature of the console command.
    protected $signature = 'diaries:publish-scheduled';

    //  The console command description.
    protected $description = 'Publish scheduled diaries whose scheduled time has arrived';

    public function handle()
    {
        $diaries = DiaryEntry::where('status','scheduled')
                    ->whereNotNull('scheduled_at')
                    ->where('scheduled_at', '<=' , now())->get();
        if($diaries->isEmpty()){
            $this->info('No scheduled diaries are ready to be published.');
            return self::SUCCESS;
        }
        foreach($diaries as $diary){
            $diary->update([
                'status' => 'published',
                'published_at' => now(),
                'scheduled_at' => null,
            ]);
            $this->info( "Diary ID {$diary->id} published successfully." );
        }            
        $this->info( "{$diaries->count()} scheduled diary(s) published." ); 
        return self::SUCCESS;
    }
}
