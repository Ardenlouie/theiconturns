<?php

use Livewire\Component;
use App\Models\RegisterInvite;

new class extends Component
{
    public $rsvp;
    public $data = [];

    protected $listeners = ['confirmInvite' => 'loadData'];

    public function loadData($data)
    {
        $this->rsvp= RegisterInvite::where('id', $data['id'])->first();

    }
};
?>

<div>
    <div class="modal-content">
        @if(!empty($rsvp))
        <div class="modal-body ">
            @include('pages.invites.invite' )
        </div>
        @endif
    </div>
</div>