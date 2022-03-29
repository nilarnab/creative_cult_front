@extends('layouts.head')
@extends('layouts.general')

@section('main')
@endsection



@section('style_main')

    <div class="elevate" style="width: 100%; height: auto; padding: 40px; margin-top: 100px">

        <h3 align="center">Create event</h3>
        <div class="form-group">
            <label for="usr">Event Name</label>
            <input type="text" class="form-control" id="usr" name="name">
        </div>

        <div class="form-group">
            <label for="usr">Description</label>
            <textarea type="text" class="form-control" id="usr" name="descript"></textarea>
        </div>


        <div class="form-group">
            <label for="usr">Starting</label>
            <input type="datetime-local" class="form-control" id="usr" name="start">
        </div>

        <div class="form-group">
            <label for="usr">Ending</label>
            <input type="datetime-local" class="form-control" id="usr" name="end">
        </div>


    </div>


@endsection


