<style>
    {{--    Styles for login panel--}}
    * {
        box-sizing: border-box;
    }
    body {
        margin: 0;
        /*Display width and height*/
        height: 100vh;
        width: 100vw;
        overflow: hidden;
        font-family: "Lato", sans-serif;
        font-weight: 700;
        /* To make all the elements center */
        display: flex;
        align-items: center;
        justify-content: center;
        /*Font color and background Color*/
        color: #555;
        background: #ecf0f3;
    }
    .div {
        /* Login Card Width and height */
        width: 430px;
        height: 500px;
        /* padding */
        padding: 20px 35px 15px 35px;
        border-radius: 35px;
        background: #ecf0f3;
        /* Box-shadow for 3d visualization*/
        box-shadow:
            -6px -6px 6px rgba(255, 255, 255, 0.8),
            6px 6px 6px rgba(0, 0, 0, 0.2);
    }
    .logo {
        background: url("logo.png");
        background-size: cover;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin: 0 auto;
        /* Box-shadow for logo */
        box-shadow: 0px 0px 2px #5f5f5f,
        0px 0px 0px 5px #ecf0f3,
        8px 8px 15px #a7aaaf,
        -8px -8px 15px #ffffff;
    }
    .title {
        text-align: center;
        font-size: 28px;
        padding-top: 24px;
        letter-spacing: 0.5px;
        color: #5eadd8;
    }
    .sub-title {
        text-align: center;
        font-size: 15px;
        padding-top: 7px;
        letter-spacing: 3px;
        color: #5eadd8;
    }
    .input-fields {
        width: 100%;
        padding: 20px 5px 10px 5px;
    }
    .input-fields input {
        /* To hide default browser options of input field */
        border: none;
        outline: none;
        /* Custom design for the input field */
        background: none;
        font-size: 18px;
        color: #555;
        padding: 15px 10px 15px 5px;
    }
    .email,
    .password {
        margin-bottom: 20px;
        border-radius: 20px;
        /* Box-shadow for 3d */
        box-shadow: inset 5px 5px 5px #cbced1,
        inset -5px -5px 5px #ffffff;
    }
    .input-fields svg {
        height: 22px;
        margin: 0 10px -3px 25px;
    }
    .button {
        /* To hide default browser options of input field */
        outline: none;
        border: none;
        /* Custom design for the Button */
        cursor: pointer;
        width: 100%;
        height: 60px;
        border-radius: 25px;
        font-size: 20px;
        font-weight: 700;
        font-family: "Lato", sans-serif;
        color: #fff;
        text-align: center;
        background: #5eadd8;
        box-shadow: 7px 7px 8px #cbced1,
        -7px -7px 8px #ffffff;
        transition: 0.5s;
    }
    .button:hover {
        background: #3d6c8f;
    }
    .button:active {
        background: #3d6c8f;
    }
    .link {
        padding-top: 20px;
        text-align: center;
    }
    .link a {
        text-decoration: none;
        color: #aaa;
        font-size: 15px;
        transition: 0.5s;
    }
    .link a:hover {
        text-decoration: none;
        color: #67d18a;
        font-size: 15px;
    }
</style>

@yield('style_main')
