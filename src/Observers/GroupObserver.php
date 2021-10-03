<?php

namespace Trainner\Observers;

use Trainner\Models\Group;
use Trainner\Models\Collaborator;
use Trainner\Models\Phone;
use Trainner\Models\Addresse;
use Trainner\Models\Email;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Trainner\Util\Filter;
use Trainner\Services\Operadora;
use Trainner\Services\FraudAnalysi;

class GroupObserver implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Handle the group "creating" event.
     *
     * @param Group $group
     *
     * @return true
     */
    public function creating(Group $group): bool
    {
        
        return true;
    }

    /**
     * Handle the group "created" event.
     *
     * @param Group $group
     *
     * @return void
     */
    public function created(Group $group)
    {
        return $this->change($group);
    }

    /**
     * Handle the group "change" event.
     *
     * @param Group $group
     *
     * @return void
     */
    public function change(Group $group)
    {
        
    }

    /**
     * Handle the group "updated" event.
     *
     * @param Group $group
     *
     * @return void
     */
    public function updated(Group $group)
    {
        return $this->change($group);
    }

    /**
     * Handle the group "deleted" event.
     *
     * @param Group $group
     *
     * @return void
     */
    public function deleted(Group $group)
    {
        //
    }

    /**
     * Handle the group "restored" event.
     *
     * @param Group $group
     *
     * @return void
     */
    public function restored(Group $group)
    {
        //
    }

    /**
     * Handle the group "force deleted" event.
     *
     * @param Group $group
     *
     * @return void
     */
    public function forceDeleted(Group $group)
    {
        //
    }
}
