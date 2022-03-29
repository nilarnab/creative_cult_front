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

            <div class="elevate cards" style="height: 360px !important; padding: 60px">
                <br>
                <h3 align="center" class="green">{{$request_info['stage'] * 25}} % Complete</h3>
                <br>

                <div class="bar" style="width: {{$request_info['stage'] * 25}}%"></div>

            </div>
            <br>

            <div class="elevate cards" style="height: 260px !important; overflow: auto">
                <br><br>
                <h3 align="center" >Stage</h3>
                <div class="line" style="margin: auto"></div>
                <br>

                <h3 align="center" class="green">{{$request_info['has_stage']['value']}}</h3>

            </div>

        </div>

        <div class="col-6">

            <div class="elevate cards" style="width: 100%; height: auto !important; padding: 40px;">

                <form method="post" action="/change_status">
                    @csrf

                    <h3 align="center">Change Stage</h3>
                    <div class="form-group">

                        <div style="visibility: hidden">
                            <input name="id" value="{{$request_id}}">
                        </div>

                        <select class="form-select form-select-lg" style="width: 100%" name="new_status">
                            @foreach($all_stages as $stage)
                                <option value="{{$stage['id']}}">{{$stage['value']}}</option>
                            @endforeach
                        </select>

                    </div>

                    <button role="button" class="btn btn-success">Submit</button>

                </form>

            </div>
            <br>
            <div class="elevate cards" style="padding: 40px; height: 200px !important;">

                <form action="set_price" method="post">
                    @csrf


                    <div class="form_group">

                        <p>Start Estimate: {{$request_info['amount_range_start']}}, End Estimate: {{$request_info['amount_range_end']}} </p>
                        <input name="id" value="{{$request_id}}" style="display: none">

                        <input type="number" class="form-control" name="price" placeholder="Price in rupees, Currently: {{$request_info['final_cost']}}">
                        <br>
                        <button class="btn btn-success" type="submit">Submit</button>

                        <br>
                        @if(Session::has('message_price'))
                            {!! Session::get('message_price') !!}
                        @endif

                    </div>
                </form>
            </div>

            <br>


            <div class="elevate cards" style="width: 100%; height: auto !important; padding: 40px;">

                <form  action="/upload_request_photo" method="post" enctype="multipart/form-data">
                    @csrf

                    <h3 align="center">Upload Photo</h3>
                    <input name="id" value="{{$request_id}}" style="display: none">
                    <input type="file" name="image">
                    <br>

                    <button role="button" class="btn btn-success">Submit</button>

                    @if(Session::has('success_photo'))
                        <p style="color: green" align="center">{!! Session::get('success_photo') !!}</p>
                    @endif

                </form>

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
        <tr>
            <td class="dark" align="center">Requester name</td>
            <td align="center">{{$request_info['has_requester']['name']}}</td>
        </tr>
        <tr>
            <td class="dark" align="center">Requester Mail</td>
            <td align="center">{{$request_info['has_requester']['email']}}</td>
        </tr>
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

