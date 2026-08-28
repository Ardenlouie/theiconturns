<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegisterInvite;
use App\Http\Traits\SettingTrait;
use App\Http\Requests\InviteUpdateRequest;
use App\Exports\RegisterInviteExport;
use Maatwebsite\Excel\Facades\Excel;

class InviteController extends Controller
{
    use SettingTrait;

    public function index(Request $request)
    {
        $search = trim($request->get('search') ?? '');
        $status = $request->query('status');

        $invite_count = RegisterInvite::all()->count();
        $attending_count = RegisterInvite::where('attending', 'YES')->count();
        $confirmed_count = RegisterInvite::where('attending', 'YES')->where('confirm', 1)->count();

        $invites = RegisterInvite::orderBy('created_at', 'DESC')
            ->when(!empty($search), function($query) use($search) {
                $query->where(function($q) use($search) {
                    $q->where('control_number', 'like', "%$search%")
                    ->orWhere('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
                });
            })
            ->when($status, function($q) use ($status) {
                if ($status === 'null') {
                    $q->whereNull('confirm');
                } else {
                    $q->where('confirm', $status);
                };
            })
            ->paginate($this->getDataPerPage())
            ->appends(request()->query());

        if ($request->ajax()) {
            return view('pages.invites.partials')->with([
                'invites' => $invites,
                'invite_count' => $invite_count,
                'attending_count' => $attending_count,
                'confirmed_count' => $confirmed_count,
            ])->render();
        }

        return view('pages.invites.index')->with([
            'search' => $search,
            'invites' => $invites,
            'invite_count' => $invite_count,
            'attending_count' => $attending_count,
            'confirmed_count' => $confirmed_count,
        ]);
    }

    public function update(InviteUpdateRequest $request, $id)
    {
        $invite = RegisterInvite::findOrFail(decrypt($id));

        $changes_arr['old'] = $invite->getOriginal();

        $invite->update([
            'confirm' => $request->confirm,
        ]);

        $changes_arr['changes'] = $invite->getChanges();

        // logs
        activity('updated')
            ->performedOn($invite)
            ->withProperties($changes_arr)
            ->log(':causer.name has updated a invite :subject.name');

        return back()->with([
            'message_success' => __('Invite has updated successfully'),
        ]);
    }

    public function show($id)
    {
        $rsvp = RegisterInvite::findOrFail(decrypt($id));

        return view('pages.invites.show')->with([
            'rsvp' => $rsvp,
        ]);
    }

    public function export()
    {
        return Excel::download(new RegisterInviteExport, 'register_invites_' . now()->format('Y_m_d') . '.xlsx');
    }
}
