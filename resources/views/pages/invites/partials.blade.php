<table class="table table-sm table-striped table-hover mb-0 rounded">
    <thead class="tex-center bg-dark">
        <tr class="text-center">
            <th>{{__('Name')}}</th>
            <th>{{__('Email')}}</th>
            <th>{{__('Date Submitted')}}</th>
            <th>{{__('Attendance')}}</th>
            <th>{{__('Confirmation')}}</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($invites as $invite)
            <tr>
                <td class="align-middle text-center">
                    {{$invite->name}}
                </td>
                <td class="align-middle text-center">
                    {{$invite->email}}
                </td>
                <td class="align-middle text-center">
                    {{ date('F d, Y', strtotime($invite->created_at ?? '')) }}
                </td>
                <td class="align-middle text-center">
                    @if($invite->attending == 'YES')
                        <span class="badge badge-success"><b>YES</b></span>
                    @else
                        <span class="badge badge-danger"><b>NO</b></span>
                    @endif
                </td>
                <td class="align-middle text-center">
                    @if(is_null($invite->confirm))
                        <span class="badge badge-warning"><b>NOT YET CONFIRMED</b></span>
                    @elseif($invite->confirm == 0)
                        <span class="badge badge-danger"><b>NOT GUEST</b></span>
                    @elseif($invite->confirm == 1)
                        <span class="badge badge-success"><b>CONFIRMED GUEST</b></span>
                    @endif
                </td>
                <td class="align-middle text-right p-0 pr-1">
                    @if($invite->attending == 'YES')
                        <a href="#" title="confirm" data-id="{{$invite->id}}" class="btn btn-confirm btn-success btn-xs mb-0 ml-0">
                            <i class="fa fa-pen-alt"></i> CONFIRM
                        </a>
                    @endif
                    <a href="{{ route('invite.show', encrypt($invite->id)) }}" title="show" class="btn bg-primary btn-xs mb-0 ml-0">
                        <i class="fa fa-eye"></i> SHOW
                    </a>
                    
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
{{ $invites->appends(request()->query())->links() }}
