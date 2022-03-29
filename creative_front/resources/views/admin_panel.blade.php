@extends('layouts.head')
@extends('layouts.general')


@section('main')
@endsection


@section('style_main')


    <style>


        .cards
        {
            height: 500px !important;
            width: 100% !important;
            border-radius: 20px;
        }

    </style>
    <br><br>



    <div class="row">
        <div class="col-6">

            <div class="elevate cards" style="height: 260px !important;">
                <br><br>
                <h3 align="center">Profile</h3>
                <br>
                <div class="line" style="margin: auto">

                </div>
                <br>

                <div class="row">
                    <div class="col-6" align="center">
                        <h4>Name</h4>
                    </div>
                    <div class="col-6" align="center">
                        <h4>{{$user['name']}}</h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6" align="center">
                        <h4>Email</h4>
                    </div>
                    <div class="col-6" align="center">
                        <h4>{{$user['email']}}</h4>
                    </div>
                </div>

            </div>
            <br>

            <div class="elevate cards" style="height: 260px !important; overflow: auto">
                <br><br>
                <h3 align="center">All Events</h3>
                <div class="line" style="margin: auto"></div>
                <br>
                <table class="table" style="width: 95%; margin: auto">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Sl No</th>
                        <th scope="col">Name</th>
                        <th scope="col">Number of Entries</th>
                        <th scope="col">Link</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($events as $event)
                        <tr>
                            <th scope="row">{{$event['id']}}</th>
                            <td>{{$event['name']}}</td>
                            <td>{{$event['no_of_entries']}}</td>
                            <td><a href="./show_event_details?id={{$event['event_id']}}">Link</a> </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>


            </div>

        </div>

        <div class="col-6">

            <div class="elevate cards" style="width: 100%; height: auto !important; padding: 40px;">

                <form  action="/create_event" method="post">
                    @csrf

                    <h3 align="center">Create event</h3>
                    <div class="form-group">
                        <label for="usr">Event Name</label>
                        <input type="text" class="form-control" id="usr" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="usr">Description</label>
                        <textarea type="text" class="form-control" id="usr" name="descript" required></textarea>
                    </div>


                    <div class="form-group">
                        <label for="usr">Starting</label>
                        <input type="datetime-local" class="form-control" id="usr" name="start" required>
                    </div>

                    <div class="form-group">
                        <label for="usr">Ending</label>
                        <input type="datetime-local" class="form-control" id="usr" name="end" required>
                    </div>

                    <button role="button" class="btn btn-success">Submit</button>

                    @if(Session::has('message_event'))
                        {!! Session::get('message_event') !!}
                        @endif

                </form>




            </div>

        </div>
    </div>
    <br>
    <br>

    <div class="row">
        <div class="col-12">

            <br><br>
            <h3 align="center">All Accepted Requests</h3>
            <div class="line" style="margin: auto"></div>
            <br>

            @if(sizeof($accepted_requests) == 0)
                <p align="center">Nothing here</p>
            @else

            <table class="table" style="width: 95%; margin: auto">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Deadline</th>
                    <th scope="col">Link</th>
                </tr>
                </thead>
                <tbody>

                @foreach($accepted_requests as $request)
                    <tr>
                        <th scope="row">{{$request['title']}}</th>
                        <td>{{$request['description']}}</td>
                        <td>{{$request['expected_deadline']}}</td>
                        <td><a href="/stage?id={{$request['id']}}">Link</a></td>
                    </tr>
                @endforeach

                </tbody>
            </table>

            @endif



        </div>
    </div>

    <div class="row">
        <div class="col-12">

            <br><br>
            <h3 align="center">All Requests</h3>
            <div class="line" style="margin: auto"></div>
            <br>

            @if(sizeof($all_requests) == 0)
                <p align="center">Nothing here</p>
            @else

                <table class="table" style="width: 95%; margin: auto">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Deadline</th>
                        <th scope="col">Link</th>
                        <th scope="col">Status</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($all_requests as $request)
                        <tr>
                            <th scope="row">{{$request['title']}}</th>
                            <td>{{$request['description']}}</td>
                            <td>{{$request['expected_deadline']}}</td>
                            <td><a href="/accept_request?request_id={{$request['id']}}">link</a></td>
                            @if(!empty($request['acceptor_id']))
                                <td>Taken</td>
                            @else
                                <td>Available</td>
                            @endif
                        </tr>
                    @endforeach

                    </tbody>
                </table>

            @endif



        </div>
    </div>

@endsection
