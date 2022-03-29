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

    <h3 align="center">Request handler window</h3>
    <div class="line" style="margin: auto"></div>
    <br><br>

    @if(!empty($request_info['pic']))
        <h3 align="center">Work done so far</h3>
        <div class="elevate cards" align="center" style="padding: 40px; height: auto !important;">
            <img src="{{$request_info['pic']}}" style="margin: auto; width: 60%; height: auto; border-radius: 20px;" align="center">
        </div>

        <br><br>
    @endif

    <div class="row">
        <div class="col-6">

            <div class="elevate cards" style="height: 260px !important; padding: 60px">
                <br>
                <h3 align="center" class="green">{{$request_info['stage'] * 25}} % Complete</h3>
                <br>

                <div class="bar" style="width: {{$request_info['stage'] * 25}}%"></div>

            </div>
        </div>
            <br>

        <div class="col-6">
            <div class="elevate cards" style="height: 260px !important; overflow: auto">
                <br><br>
                <h3 align="center" >Stage</h3>
                <div class="line" style="margin: auto"></div>
                <br>

                <h3 align="center" class="green">{{$request_info['has_stage']['value']}}</h3>

            </div>

        </div>


    </div>
    <br>
    <br>

    <h3 align="center">Request summary</h3>
    <table class="table" style="width: 95%; margin: auto">

        <tbody>

        <tr>
            <td class="dark" align="center">Title</td>
            <td align="center">{{$request_info['title']}}</td>
        </tr>
        <tr>
            <td class="dark" align="center">Description</td>
            <td align="center">{{$request_info['description']}}</td>
        </tr>
        @if(!empty($request_info['has_acceptor']))
        <tr>
            <td class="dark" align="center">Acceptor name</td>

            <td align="center">{{$request_info['has_acceptor']['name']}}</td>
        </tr>
        <tr>
            <td class="dark" align="center">Acceptor Mail</td>
            <td align="center">{{$request_info['has_acceptor']['email']}}</td>
        </tr>
        @endif
        <tr>
            <td class="dark" align="center">Requester Address</td>
            <td align="center">{{$request_info['postal_address']}}</td>
        </tr>

        <tr>
            <td class="dark" align="center">Does want delivery</td>
            @if($request_info['is_delivery'])
                <td align="center">YES</td>
            @else
                <td align="center">NO</td>
            @endif
        </tr>


        </tbody>
    </table>

    <br>
    <br>

@endsection

