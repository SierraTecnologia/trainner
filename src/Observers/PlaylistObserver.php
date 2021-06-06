<?php

namespace Trainner\Observers;

use Trainner\Models\Playlist;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class PlaylistObserver implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Handle the playlist "creating" event.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return void
     */
    public function creating(Playlist $playlist)
    {
        return true;
    }

    /**
     * Handle the playlist "created" event.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return void
     */
    public function created(Playlist $playlist)
    {
        return true;
    }

    /**
     * Handle the playlist "updated" event.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return void
     */
    public function updated(Playlist $playlist)
    {
        return true;
    }

    /**
     * Handle the playlist "deleted" event.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return void
     */
    public function deleted(Playlist $playlist)
    {
        //
    }

    /**
     * Handle the playlist "restored" event.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return void
     */
    public function restored(Playlist $playlist)
    {
        //
    }

    /**
     * Handle the playlist "force deleted" event.
     *
     * @param  \App\Models\Playlist  $playlist
     * @return void
     */
    public function forceDeleted(Playlist $playlist)
    {
        //
    }
}
