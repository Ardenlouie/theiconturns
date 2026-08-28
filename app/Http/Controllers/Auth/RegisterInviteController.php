<?php

namespace App\Http\Controllers\Auth;

use App\Models\RegisterInvite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RegisterInviteRequest;

use Illuminate\Notifications\Notification;
use App\Notifications\RegisterNotification;
use App\Notifications\IconNotification;

class RegisterInviteController extends Controller
{
    protected $redirectTo = '/thank-you';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    private function generateControlNumber() {
        $date_code = date('Ymd');

        do {
            $control_number = 'RSVP-'.$date_code.'-001';

            $pet = RegisterInvite::withTrashed()->orderBy('control_number', 'DESC')
                ->first();
            if(!empty($pet)) {
                $latest_control_number = $pet->control_number;
                list(, $prev_date, $last_number) = explode('-', $latest_control_number);

                $number = ($date_code == $prev_date) ? ((int)$last_number + 1) : 1;

                $formatted_number = str_pad($number, 3, '0', STR_PAD_LEFT);

                $control_number = "RSVP-$date_code-$formatted_number";
            }

        } while(RegisterInvite::withTrashed()->where('control_number', $control_number)->exists());

        return $control_number;
        
    }

    public function register_attendees()
    {   
        $control_number = $this->generateControlNumber();

        return view('start')->with([
            'control_number' => $control_number,
     
        ]);
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function register_invite(RegisterInviteRequest $request)
    {
        $request->control_number = $this->generateControlNumber();

        $rsvp = new RegisterInvite([
            'name' => $request->name,
            'email' => $request->email,
            'control_number' => $request->control_number,
            'company' => $request->company,
            'title' => $request->title,
            'notes' => $request->notes,
            'attending' => $request->attending,
        ]);
        $rsvp->save();

        $rsvp_id = encrypt($rsvp->id);
        
        $icon = User::where('email', 'theiconturns20@kojiesan.com')->first();
        // $icon = User::where('email', 'ardenlouie.giron@kojiesan.com')->first();

        if (!empty($icon)) {
            $icon->notify(new IconNotification($rsvp));
        }

        $rsvp->notify(new RegisterNotification($rsvp));

        return redirect()->route('thank-you', ['rsvp_id' => $rsvp_id]);
    }

    public function thank_you($rsvp_id)
    {   
        $rsvp = RegisterInvite::findOrFail(decrypt($rsvp_id));

        return view('thank-you')->with([
            'rsvp' => $rsvp,

        ]);
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(RegisterInvites $registerInvites)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RegisterInvites $registerInvites)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RegisterInvites $registerInvites)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RegisterInvites $registerInvites)
    {
        //
    }
}
