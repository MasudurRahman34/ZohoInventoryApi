<?php

namespace App\Jobs\V1;

use App\Models\Media;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class QueuedMediaUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $tries = 3;
    public $file;
    public $save_destination_path;
    public function __construct($file, $save_destination_path)
    {
        $this->file = $file;
        $this->save_destination_path = $save_destination_path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $file = Storage::put($this->save_destination_path, $this->file);
        $savePath = Storage::url($file);
        return $savePath;
    }
    public function failed(Exception $exception)
    {
        throw $exception;
    }
}
