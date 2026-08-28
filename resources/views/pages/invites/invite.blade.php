<div class="card">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-12 text-center text-uppercase mb-3">
                
                <h3><b>{{ $rsvp->control_number }}</b></h3>
                @if(is_null($rsvp->confirm))
                    <h3 class="text-uppercase">
                        <span class="badge badge-warning"><b>NEW RSVP</b></span>
                    </h3>
                @elseif($rsvp->confirm == 0)
                    <h3 class="text-uppercase">
                        <span class="badge badge-danger"><b>NOT GUEST</b></span>
                    </h3>
                @elseif($rsvp->confirm == 1)
                    <h3 class="text-uppercase">
                        <span class="badge badge-success"><b>CONFIRMED GUEST</b></span>
                    </h3>
                @endif
                
            </div>
            <div class="col-12">
                <h4>Name: <b>{{ ($rsvp->name ?? '' )}}</b></h4>
                <h4>Email: <b>{{ ($rsvp->email ?? '' )}}</b></h4>
            </div>
            <div class="col-12">
                <h4>Company: <b>{{ ($rsvp->company ?? '' )}}</b></h4>
                <h4>Position / Title: <b>{{ ($rsvp->title ?? '' )}}</b></h4>
                <h4>Notes: <b>{{ ($rsvp->notes ?? '' )}}</b></h4>
                <h4>Date Submitted: <b>{{ date('F d, Y', strtotime($rsvp->created_at ?? '')) }}</b></h4>
            </div>
        </div>
        <div class="col-12 text-center  mb-3">
            <form action="{{ route('invite.update',encrypt($rsvp->id)) }}" method="POST" id="confirming">
                @csrf          
                <div class="form-group">
                    <input type="hidden" id="confirm" name="confirm" form="confirming" value="0">
                    @if(is_null($rsvp->confirm))
                    <label>
                        <a href="#" title="approve" class="btn-approve btn bg-success btn-lg">CONFIRM</a>
                        <a href="#" title="decline" class="btn-decline btn bg-danger btn-sm">DECLINE</a>
                        
                    </label>
                    @elseif($rsvp->confirm == 0)
                        <a href="#" title="approve" class="btn-approve btn bg-success btn-lg">REVERT TO CONFIRMED GUEST</a>
                    @elseif($rsvp->confirm == 1)
                        <a href="#" title="decline" class="btn-decline btn bg-danger btn-lg">REVERT TO NOT GUEST</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>