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

    <h3 align="center">Entry Details Window</h3>
    <div class="line" style="margin: auto"></div>
    <br><br>

    @if(!empty($entry['pic']))
        <div class="row">

            <div class="col-12">

                <div class="elevate cards" style="height: auto !important; padding: 60px; justify-content: center" align="center">
                    <br>
                    <img src="{{$entry['pic']}}" style="margin: auto; width: 60%; height: auto; border-radius: 20px;" align="center">
                    <br>


                </div>
            </div>
            <br>
        </div>
    @endif



    <br><br>

    <div class="row">
        <div class="col-6">
            <div class="elevate cards" style="height: 260px !important; overflow: auto">
                <br><br>
                <h3 align="center">Marks</h3>

                @if(!empty($entry['points']))
                    <h2 class="green" align="center">{{$entry['points']}}</h2>
                @else
                    <h3 align="center">Marks not provided</h3>
                @endif
            </div>

        </div>
        <div class="col-6">
            <div class="elevate cards" style="height: 260px !important; overflow: auto">
                <br><br>
                <form method="post" action="/handle_marks">
                    @csrf

                    <h3 align="center" >Provide marks</h3>
                    <div class="line" style="margin: auto"></div>
                    <br><br>

                    <div class="form-group">


                    <input value="{{$entry['id']}}" name="entry_id" style="display: none">

                    <input class="form-control" type="number" name="marks" placeholder="marks out of 100" style="width: 60%; margin: auto">

                    </div>

                    <div id="message_marks">
                        @if(Session::has('message_marks'))
                            <div align="center">{!! Session::get('message_marks') !!}</div>
                        @endif
                    </div>

                    <div align="center">
                        <button type="submit" role="button" class="btn btn-success">Submit</button>
                    </div>




                </form>


{{--                <h3 align="center" class="green">{{$request_info['has_stage']['value']}}</h3>--}}

            </div>

        </div>



    </div>
    <br>
    <br>

    <h3 align="center">Entry Details</h3>
    <table class="table" style="width: 95%; margin: auto">

        <tbody>

        <tr>
            <td class="dark" align="center">Name</td>
            <td align="center">{{$entry['has_participant']['name']}}</td>
        </tr>
        <tr>
            <td class="dark" align="center">Email</td>
            <td align="center">{{$entry['has_participant']['email']}}</td>
        </tr>

        <tr>
            <td class="dark" align="center">Event Name</td>
            <td align="center">{{$entry['has_event']['event_name']}}</td>
        </tr>

        <tr>
            <td class="dark" align="center">Event Description</td>
            <td align="center">{{$entry['has_event']['description']}}</td>
        </tr>

        </tbody>
    </table>

    <br>
    <br>

@endsection

