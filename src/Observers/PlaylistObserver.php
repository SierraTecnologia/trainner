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
     * @param Playlist $playlist
     *
     * @return true
     */
    public function creating(Playlist $playlist): bool
    {
        return true;
    }

    /**
     * Handle the playlist "created" event.
     *
     * @param Playlist $playlist
     *
     * @return true
     */
    public function created(Playlist $playlist): bool
    {
        return true;
    }

    /**
     * Handle the playlist "updated" event.
     *
     * @param Playlist $playlist
     *
     * @return true
     */
    public function updated(Playlist $playlist): bool
    {
        return true;
    }

    /**
     * Handle the playlist "deleted" event.
     *
     * @param Playlist $playlist
     *
     * @return void
     */
    public function deleted(Playlist $playlist)
    {
        //
    }

    /**
     * Handle the playlist "restored" event.
     *
     * @param Playlist $playlist
     *
     * @return void
     */
    public function restored(Playlist $playlist)
    {
        //
    }

    /**
     * Handle the playlist "force deleted" event.
     *
     * @param Playlist $playlist
     *
     * @return void
     */
    public function forceDeleted(Playlist $playlist)
    {
        //
    }
}
