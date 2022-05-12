@extends('layouts.head')







    <style>

        .elevate
        {
            background: #e0e0e0;
            box-shadow:  10px 10px 20px #bebebe,
            -10px -10px 20px #ffffff;
            border-radius: 20px;
        }

        .cards
        {
            height: 500px !important;
            width: 100% !important;
            border-radius: 20px;
        }
    </style>

    <br><br>

    <div class="elevate cards" style="height: auto !important; padding: 40px; width: 40% !important; margin: auto !important;">

        <div class="logo" align="center">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTLTuYtEHvUAisdjSqS0zCycC9GxKD7sTzLrEMmFY7wcrmw1lTRZyJPVFPY5tRJBSMMHhw&usqp=CAU" height="100px" style="border-radius: 50%" width="100px">
        </div>

        <br>
        <h3 align="center">Register</h3>
        <div class="line" style="margin: auto"></div>
        <br>

        <form method="post" action="handle_register" enctype="multipart/form-data">
            @csrf

            <div class="form_group">
                <input class="form-control" name="name" placeholder="Name">
            </div>

            <br>

            <div class="form_group">
                <input class="form-control" type="email" name="email" placeholder="Enter Email eg: harrypotter@hogwarts.com">

            </div>

            <br>

            <div class="form_group">
                <input type="password" class="form-control" name="password" placeholder="Password">

            </div>

            <br>

            <div class="form_group">
                <input type="password" class="form-control" name="conf_password" placeholder="Confirm Password">

            </div>

            <br>


            <button class="btn btn-success" type="submit">Submit</button>

            <br>
            @if(Session::has('message_register'))
                {!! Session::get('message_register') !!} Go to <a href="./">login</a>
            @endif

        </form>

    </div>



