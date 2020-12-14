@extends('layouts.app')

@section('title', 'Listing')

  @section('content')
    @if(session()->has('cancel'))
        <p class="alert-info">{!! session()->get('cancel') !!}</p>
        <br>
    @endif  
    <table>
        <head>
            <tr>
                <th>Event Name</th>
                <th>List Name</th>
                <th>Max Applicants</th>
                <th>Available Places</th>
                <th>Name</th>
                <th>Application date</th>
                <th>Time</th>
                <th>Attended</th>
            </tr>
        </head>
        <tbody>
        <tr>
            <td>{{ $event->name }}</td>
            <td>{{ $list->name }}</td>
            <td>{{ $list->max_applicants }}</td>
            <td>{{ $list->max_applicants - count($list->applicants)}}</td>
        </tr>
        @foreach($list->applicants as $applicant)
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ $applicant->first_name }} {{ $applicant->last_name }}</td>
                <td>{{ $applicant->created_at->format('l jS \\of F Y') }}</td>
                <td>{{ $applicant->created_at->format('h:i:s A') }}</td>
                    
                    @can('view', $applicant)
                        <td>
                            <a href="{{ route('applicants.show', [ $applicant, 'event' => $event, 'list' => $list ]) }}">Details</a>
                        </td>

                        <td>
                            <form action="{{ route('applicants.destroy', $applicant) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="applicant_id" value="{{ $applicant->id }}">
                                <input type="hidden" name="event" value="{{ $event->id }}">
                                <input type="hidden" name="list_id" value="{{ $list->id }}">
                                <input type="submit" value="Delete">
                            </form>
                        </td>
                    @endcan

                    @can('organiser-view', $user)
                        <td>
                            <input 
                                id="applicant" 
                                type="checkbox" 
                                name="{{ $list->id }}"
                                value="{{ $applicant->id }}"
                                onclick="sendData({{ $list->id }}, {{ $applicant->id }} )">
                        </td>
                        <td>
                            <a href="{{ route('applicants.show', [ $applicant, 'event' => $event, 'list' => $list ]) }}">Details</a>
                        </td>

                        <td>
                            <form action="{{ route('applicants.destroy', $applicant) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="applicant_id" value="{{ $applicant->id }}">
                                <input type="hidden" name="event" value="{{ $event->id }}">
                                <input type="hidden" name="list_id" value="{{ $list->id }}">
                                <input type="submit" value="Delete">
                            </form>
                        </td>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @if( session('warning'))
        <br>
        {{ session('warning') }} <br><br><a href="{{ route('login', ['list' => $list, 'event' => $event]) }}">sign in?</a>
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
    <br><br>

    @can('addMe', $user)
        @if (count($list->applicants) < $list->max_applicants && !$isOnList)
            <a href="{{ route('applicants.create', [ 'list' => $list, 'event' => $event]) }}">Add me!</a>
        @endif
    @endcan
    <br><br>
    <a href="{{ route('events.show', $event) }}">Back to Slot</a>
    <br><br>

    @can('organiser-view', $user)
        <a href="{{ route('applicant_lists.edit', [$list, 'event' => $event]) }}">Edit List</a>
        <br><br>
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