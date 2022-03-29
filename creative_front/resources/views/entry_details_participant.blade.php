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

        .green
        {
            background: -webkit-linear-gradient(90deg, #0e3504, #17a20a);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .bar
        {
            height: 30px;
            background: linear-gradient(90deg, #0e3504, #17a20a);
        }

        .gradient_color
        {
            background: linear-gradient(120deg, #17a20a, #0e3504);
        }

        .dark
        {
            background-color: #373737;
            color: white;
        }

    </style>
    <br><br>

    <h3 align="center">Take part in an event</h3>
    <div class="line" style="margin: auto"></div>
    <br><br>

    <div class="row">
        <div class="col-6">
            <div class="elevate cards" style="height: 260px !important; overflow: auto; padding: 40px">

                @if($unattended_count == 0)
                    <p align="center" style="color: red"><br><br>Nothing here</p>
                @else
                <form method="post" enctype="multipart/form-data" action="/handle_new_entry">
                    @csrf
                    <div class="form-group" style="margin: auto">
                        <br>
                        <br>
                        <input value="{{$user_id}}" name="user_id" style="display: none">


                        <select class="form-select form-select-lg" name="event_id" style="width: 100%; height: 30px">

                                @foreach($all_events as $event)
                                    @if(!$event['attended'])
                                        <option value="{{$event['id']}}" style="height: 30px">{{$event['event_name']}}</option>
                                    @endif
                                @endforeach

                        </select>


                    </div>

                    <br>
                    <input type="file" name="image">
                    <br>
                    <button class="btn btn-success" role="button">Submit</button>

                    @if(Session::has('success_photo'))
                        <p style="color: green" align="center">{!! Session::get('success_photo') !!}</p>
                    @endif


                </form>
                @endif


            </div>
        </div>
        <div class="col-6">
            <div class="elevate cards green" style="height: 260px !important; overflow: auto; padding: 30px; font-size: 20px">
                <p>In the left hand side, you will be able to see all the events that you have not attended yet</p>
                <p>Go ahead and select one</p>
            </div>
        </div>
    </div>



    <br>

    <h3 align="center">All events</h3>
    <table class="table table-hover">

        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">DeadLine (yyyy:mm:dd hh:mm:ss)</th>
            <th scope="col">Attended/ missed</th>
            <th scope="col">Marks</th>
        </tr>
        </thead>

        <tbody>
        @foreach($all_events as $event)

            @if(!$event['expired'])
            <tr>
                <td>{{$event['event_name']}}</td>
                <td>{{$event['description']}}</td>
                <td>{{$event['ending_time']}}</td>
                @if($event['attended'])
                    <td class="green">Attended</td>
                @else
                    <td style="color: red">Missed</td>
                @endif

                @if(!empty($event['marks']))
                    <td>{{$event['marks']}}</td>
                @else
                    <td>Not given yet</td>
                @endif
            </tr>
            @else
                <tr style="opacity: 0.5">
                    <td>{{$event['event_name']}}</td>
                    <td>{{$event['description']}}</td>
                    <td>{{$event['ending_time']}}</td>
                    @if($event['attended'])
                        <td class="green">Attended</td>
                    @else
                        <td style="color: red">Missed</td>
                    @endif

                    @if(!empty($event['marks']))
                        <td>{{$event['marks']}}</td>
                    @else
                        <td>Not given yet</td>
                    @endif

                </tr>
            @endif

        @endforeach
        </tbody>

    </table>

@endsection

