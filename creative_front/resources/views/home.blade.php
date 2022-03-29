@extends('layouts.head')
@extends('layouts.general')

@section('main')
@endsection



@section('style_main')

    <style>
        .green_card
        {
            background-color: #26810e;
            color: white;
            transition: 1s;
        }

        .green_card:hover
        {
            background-color: #092d01;
        }

    </style>

<h1 align="center">Welcome {{$user['name']}}</h1>

<br><br>
<div class="elevate profile">
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


<br><br>


<!--
For client
all the competitios
current score
-->

<div class="row">
    <div class="col-6">
        <div class="elevate" style="padding: 40px; height: 400px !important; overflow: auto">
            <h3 align="center">Your Requests</h3>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Expected deadline</th>
                    <th scope="col">Starting amount</th>
                    <th scope="col">Ending amount</th>
                    <th scope="col">Link</th>
                </tr>
                </thead>
                <tbody>

                @foreach($requests['data'] as $request)
                    <tr>
                        <th scope="row">{{$request['title']}}</th>
                        <td>{{$request['description']}}</td>
                        <td>{{$request['expected_deadline']}}</td>
                        <td>{{$request['amount_range_start']}}</td>
                        <td>{{$request['amount_range_end']}}</td>
                        <td><a href="./stage_requester?id={{$request['id']}}">Link</a></td>
                    </tr>
                @endforeach

                </tbody>
            </table>
        </div>

        <br>
        <div class="elevate green_card" style="padding: 10px; height: 100px !important;">
            <a href="/insert_new_entry"><h3 style="color: white !important;">Enter In An Event</h3></a>
            Enter the <a href="/insert_new_entry"><span style="color: #22cfc3">link</span></a> to take part in an art competition
        </div>

    </div>

    <div class="col-6 elevate profile">

        <h3 align="center">Make a new entry</h3>
        <br>

        <form method="post" action="handle_new_request" enctype="multipart/form-data">
            @csrf


            <input class="form-control" name="requester_id" value="{{$user['client_id']}}" style="display: none">

            <div class="form_group">
                <input class="form-control" name="title" placeholder="Title">

            </div>

            <br>

            <div class="form_group">
                <input class="form-control" name="description" placeholder="Description">

            </div>

            <br>

            <div class="form_group">
                <input type="number" class="form-control" name="starting_amount" placeholder="Starting amount">

            </div>

            <br>

            <div class="form_group">
                <input type="number" class="form-control" name="ending_amount" placeholder="Ending amount">

            </div>

            <br>

            <div class="form_group">
                <input class="form-control" name="address" placeholder="Address">

            </div>

            <br>

            <div class="form_group">
                <input type="date" class="form-control" name="expected_deadline" placeholder="Expected Deadline">

            </div>

            <br>

{{--            <p>Do you want the product to be delivered to you?</p>--}}

            <button class="btn btn-success" type="submit">Submit</button>

            <br>
            @if(Session::has('message_request'))
                {!! Session::get('message_request') !!}
            @endif

        </form>
    </div>
</div>

    <br>


@endsection


