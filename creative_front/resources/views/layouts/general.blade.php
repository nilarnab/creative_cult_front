<style>

    body, html
    {
        padding: 0px;
        margin: 0px;
        background-color: #eaeaea !important;
    }

    .container
    {
        width: 80%;
        margin: auto;

    }

    .elevate
    {
        background: #e0e0e0;
        box-shadow:  10px 10px 20px #bebebe,
        -10px -10px 20px #ffffff;
        border-radius: 20px;
    }

    .profile
    {
        width: 80%;
        margin: auto;
        height: auto;
        padding: 40px;
    }

    h3
    {
        color: #3d6c8f !important;
    }

    .line
    {
        width: 80%;
        height: 1px;
        background-color: #3d6c8f;
    }

</style>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#"><img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTLTuYtEHvUAisdjSqS0zCycC9GxKD7sTzLrEMmFY7wcrmw1lTRZyJPVFPY5tRJBSMMHhw&usqp=CAU" height="20px" style="border-radius: 50%" width="20px"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="./home">Home <span class="sr-only">(current)</span></a>
            </li>
{{--            <li class="nav-item">--}}
{{--                <a class="nav-link" href="#">Link1</a>--}}
{{--            </li>--}}

            <li class="nav-item">
                <a class="nav-link" href="/logout"><p style="color: tomato">Logout</p></a>
            </li>

    </div>
</nav>


<div class="container">

    @yield('style_main')

</div>
