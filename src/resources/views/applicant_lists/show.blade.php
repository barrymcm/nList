@extends('layouts.app')

@section('title', 'Listing')

@section('content')

    @if(session()->has('cancel'))
        <div class="grid grid-cols-1 w-full">
            <p class="alert-info">{!! session()->get('cancel') !!}</p>
        </div>
    @endif

    <div class="grid grid-cols-4 grid-flow-rows bg-blue-400 rounded-md text-center h-28 p-5 mb-14">
        <div class="font-medium border-b-2 border-gray-300 text-gray-100 pb-3">Event Name</div>
        <div class="font-medium border-b-2 border-gray-300 text-gray-100 pb-3">List Name</div>
        <div class="font-medium border-b-2 border-gray-300 text-gray-100 pb-3">Max Applicants</div>
        <div class="font-medium border-b-2 border-gray-300 text-gray-100 pb-3">Available Places</div>
        <div class="my-3">{{ $event->name }}</div>
        <div class="my-3">{{ $list->name }}</div>
        <div class="my-3">{{ $list->max_applicants }}</div>
        <div class="my-3">{{ $list->max_applicants - count($list->applicants)}}</div>
    </div>

    <div class="grid grid-cols-3 grid-flow-rows px-5">

        <div class="h-10 text-medium border-b-2 border-gray-700 mb-4">Name</div>
        <div class="h-10 text-medium border-b-2 border-gray-700 mb-4">Application date</div>
        <div class="h-10 text-medium border-b-2 border-gray-700 mb-4">Time</div>
        
        @can('organiser-view', $user)
            <div>Attended</div>
        @endcan
        
        @foreach($list->applicants as $applicant)
            <div class="py-1">{{ $applicant->first_name }} {{ $applicant->last_name }}</div>
            <div class="py-1">{{ $applicant->created_at->format('l jS \\of F Y') }}</div>
            <div class="py-1">{{ $applicant->created_at->format('h:i:s A') }}</div>
                
                @can('view', $applicant)
                    <div>
                        <a href="{{ route('applicants.show', [ $applicant, 'event' => $event, 'list' => $list ]) }}">Details</a>
                    </div>

                    <div>
                        <form action="{{ route('applicants.destroy', $applicant) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="applicant_id" value="{{ $applicant->id }}">
                            <input type="hidden" name="event" value="{{ $event->id }}">
                            <input type="hidden" name="list_id" value="{{ $list->id }}">
                            <input type="submit" value="Delete">
                        </form>
                    </div>
                @endcan

                @can('organiser-view', $user)
                    <div>
                        <input 
                            id="applicant" 
                            type="checkbox" 
                            name="{{ $list->id }}"
                            value="{{ $applicant->id }}"
                            onclick="sendData({{ $list->id }}, {{ $applicant->id }} )">
                    </div>
                    <div>
                        <a href="{{ route('applicants.show', [ $applicant, 'event' => $event, 'list' => $list ]) }}">Details</a>
                    </div>

                    <div>
                        <form action="{{ route('applicants.destroy', $applicant) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="applicant_id" value="{{ $applicant->id }}">
                            <input type="hidden" name="event" value="{{ $event->id }}">
                            <input type="hidden" name="list_id" value="{{ $list->id }}">
                            <input type="submit" value="Delete">
                        </form>
                    </div>
                @endcan
        @endforeach
    </div>
    @if( session('warning'))
        {{ session('warning') }}<a href="{{ route('login', ['list' => $list, 'event' => $event]) }}">sign in?</a>
        or if you dont have an account you can
        <a href="{{ route('register.select_account_type', ['list' => $list, 'event' => $event]) }}">register</a>
    @endif
 
    @if( session('notice'))
        <p class="alert-info">
            {{ session('notice') }} <a href="{{ route('customers.create', ['id' => auth()->user()->customer]) }}">Click here!</a>
        </p>
    @endif

    @if( session('status'))
        <p class="alert-info">{{ session('status') }}</p>
    @endif

    @can('addMe', $user)
        @if (count($list->applicants) < $list->max_applicants && !$isOnList)
            <a href="{{ route('applicants.create', [ 'list' => $list, 'event' => $event]) }}">Add me!</a>
        @endif
    @endcan

    <div class="flex leading-loose text-blue-700 my-10">
        <a class="flex items-center pb-3" href="{{ route('events.show', $event) }}">
            <svg class="align-center" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" width="16" height="16">
                <path fill-rule="evenodd" d="M7.78 12.53a.75.75 0 01-1.06 0L2.47 8.28a.75.75 0 010-1.06l4.25-4.25a.75.75 0 011.06 1.06L4.81 7h7.44a.75.75 0 010 1.5H4.81l2.97 2.97a.75.75 0 010 1.06z"></path>
            </svg>
        Back to Slot</a>
    </div>

    @can('organiser-view', $user)
        <a href="{{ route('applicant_lists.edit', [$list, 'event' => $event]) }}">Edit List</a>
        @if(count($list->applicants) < 1)
            <form action="{{ route('applicant_lists.destroy', $list->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="event" value="{{ $event->id }}">
                <input type="submit" name="submit" value="Cancel List">
            </form>
        @endif
        <br>
    @endcan
@endsection

<script type="text/javascript">
    var xhro = false;

    if(window.XMLHttpRequest) {
        var xhro = new XMLHttpRequest();
    }

    function sendData(listId, applicantId) 
    {
        var url = '/applicants/attended';

        if(xhro) {
            xhro.open("POST", url, true);
            xhro.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        }

        xhro.send("applicant_id=" + applicantId + "&list_id=" + listId);
    }
</script>