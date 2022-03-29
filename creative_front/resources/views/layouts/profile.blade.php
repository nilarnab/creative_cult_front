
@yield('profile')

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

