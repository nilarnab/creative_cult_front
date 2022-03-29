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

        .dark
        {
            background-color: #373737;
            color: white;
        }

    </style>


    <br><br>
    <h3 align="center">Event Entries</h3>
    <div class="line" style="margin: auto"></div>
    <br>
    <table class="table" style="width: 95%; margin: auto" align="center">
        <thead class="thead-dark">
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Link</th>
        </tr>
        </thead>
        <tbody>

        @foreach($entries as $entry)
            <tr>
                <th scope="row">{{$entry['has_participant']['name']}}</th>
                <td>{{$entry['has_participant']['email']}}</td>
                <td><a href="./show_entry?entry_id={{$entry['id']}}">Link to entry</a></td>
            </tr>
        @endforeach

        </tbody>
    </table>




@endsection
