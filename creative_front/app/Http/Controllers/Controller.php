<?php

namespace App\Http\Controllers;

//use GuzzleHttp\Psr7\Request;
use Carbon\Carbon;
//use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;
use Validator;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var string
     */
    private $URL_BASE;

    function __construct()
    {
        $this->URL_BASE = "http://127.0.0.1:8000";
    }


    function auth_login(Request $request)
    {
        $resp = $this->api_call('/login',
        [
            'email' => $request['email'],
            'password' => $request['password']
        ]);


        if ($resp['id'])
        {

            session(['user' => $resp['user']]);
            session(['session_info' => $resp['session_info']]);

            return redirect('/home');


        }
        else{
            return back()->with('error', $resp['message']);
        }
    }


    function show_home(Request $request)
    {

//        return session('session_info');

        $client = new \GuzzleHttp\Client();
        $url = $this->URL_BASE.'/show_all_requests';
        $response = $client->request('POST', $url, [
            'form_params' => [
                'client_id' => session('user')['client_id'],
                'token' => session('session_info')['token'],
                'business' =>'SHOW_ALL_REQUESTS']

        ]);
        $response = $response->getBody()->getContents();

//            return session('user');

        $response = json_decode($response, true);


        // finding where to forward the control
        if(session('user')['access'] == 0)
        {
            return view('home', [
                'user' => session('user'),
                'requests' => $response
            ]);

        }
        else
        {
            return $this->handle_admin();
        }

    }


    function handle_admin()
    {

        $client = new \GuzzleHttp\Client();
        $url = $this->URL_BASE . '/show_all_events';
        $response = $client->request('POST', $url, [
            'form_params' => [
                'client_id' => session('user')['client_id'],
                'token' => session('session_info')['token'],
                'business' => 'SHOW_ALL_REQUESTS']

        ]);
        $response = $response->getBody()->getContents();

//            return session('user');

        $response = json_decode($response, true);


        $entries = [];

        $id = 0;

        foreach ($response as $event) {

            $id++;
            $temp = [
                'id' => $id,
                'event_id' => $event['id'],
                'name' => $event['event_name'],
                'description' => $event['description'],
                'starting' => Carbon::parse($event['starting_time'])->format('Y-m-d'),
                'ending' => Carbon::parse($event['ending_time'])->format('Y-m-d'),
                'no_of_entries' => sizeof($event['has_entry'])
            ];

            array_push($entries, $temp);
        }


        # segregating requests
        $accepted_requests = [];
        $all_requests = [];

        $client = new \GuzzleHttp\Client();
        $url = $this->URL_BASE . '/show_all_requests';
        $response = $client->request('POST', $url, [
            'form_params' => [
                'token' => session('session_info')['token'],
                'business' => 'SHOW_ALL_REQUESTS']

        ]);
        $response = $response->getBody()->getContents();

//            return session('user');

        $response = json_decode($response, true);

//        return $response["data"];

        $client_id = session('user')['client_id'];


        foreach ($response['data'] as $request)
        {

            array_push($all_requests, $request);

            if ($request['acceptor_id'] != NULL)
            {
                if ($request['acceptor_id'] == $client_id)
                {
                    array_push($accepted_requests, $request);
                }

            }
        }

//        return $all_requests;


        return view('admin_panel', [
            'user' => session('user'),
            'events' => $entries,
            'all_requests' => $all_requests,
            'accepted_requests' => $accepted_requests
        ]);

    }


    function show_stages_acceptor(Request $request)
    {
        // stage -> %, stage name
        // all stages
        // requester info
        // request entry info


        $client = new \GuzzleHttp\Client();
        $url = $this->URL_BASE.'/show_one_request?id='.$request['id'];
        $response = $client->request('POST', $url, [
            'form_params' => [
                'client_id' => session('user')['client_id'],
                'token' => session('session_info')['token'],
                'business' =>'SHOW_ONE_REQUEST']

        ]);
        $response = $response->getBody()->getContents();

//            return session('user');

        $response = json_decode($response, true);

//        return $response['request_info'][0];

        $imgSrc = 'data:' . 'image/gif' . ';base64,' . $response['request_info'][0]['pic'];

        if (!empty($response['request_info'][0]['pic']))
            $response['request_info'][0]['pic'] = $imgSrc;

//        return $response['request_info'][0];

        return view('stage', [
            'request_id' => $request['id'],
            'request_info' => $response['request_info'][0],
            'all_stages' => $response['all_stages']
        ]);



    }

    function show_stages_requester(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $url = $this->URL_BASE.'/show_one_request?id='.$request['id'];
        $response = $client->request('POST', $url, [
            'form_params' => [
                'client_id' => session('user')['client_id'],
                'token' => session('session_info')['token'],
                'business' =>'SHOW_ONE_REQUEST']

        ]);
        $response = $response->getBody()->getContents();

//            return session('user');

        $response = json_decode($response, true);

//        return $response['request_info'][0];

        $imgSrc = 'data:' . 'image/gif' . ';base64,' . $response['request_info'][0]['pic'];

        if (!empty($response['request_info'][0]['pic']))
            $response['request_info'][0]['pic'] = $imgSrc;

//        return $response['request_info'][0];

        return view('client_stage', [
            'request_id' => $request['id'],
            'request_info' => $response['request_info'][0],
            'all_stages' => $response['all_stages']
        ]);
    }

    public function add_request_photo(Request $request)
    {
//        return $request->all();

        // primary validation
        $rules = array(
            'image' => 'mimes:jpeg,jpg,png,gif|required|max:1000' // max 1000kb
        );
        $validator = Validator::make($request->all(), $rules);

        // Check to see if validation fails or passes
        if ($validator->fails())
        {
            // Redirect or return json to frontend with a helpful message to inform the user
            // that the provided file was not an adequate type
            return redirect()->back()->with('success_photo', '<p style="color: red">'.$validator->errors()->getMessages()['image'][0].'</p>');
        }


        if ($request->hasFile('image')) {
            if($request->file('image')->isValid()) {

                try {
                    $file = file_get_contents($request->file('image'));
//                    return $file;
                    $image = base64_encode($file);

                    // making an api call
                    $client = new \GuzzleHttp\Client();
                    $url = $this->URL_BASE.'/add_pic_to_request';
                    $response = $client->request('POST', $url, [
                        'form_params' => [
                            'client_id' => session('user')['client_id'],
                            'token' => session('session_info')['token'],
                            'business' =>'ADD_PIC_TO_REQUEST',
                            'request_id' => $request['id'],
                            'pic' => $image
                        ]

                    ]);

                    $response = $response->getBody()->getContents();

//            return session('user');

                    $response = json_decode($response, true);

//                    return $response;

                    if ($response['id'] == 1)
                    {
                        return redirect()->back()->with('success_photo', 'Photo Upload Complete');
                    }



                } catch (FileNotFoundException $e) {
                    return "catch";

                }
            }
        }

        else
        {
            return "does not have a file";
        }


    }


    public function change_status_handle(Request $request)
    {
//        return $request->all();

        $client = new \GuzzleHttp\Client();
        $url = $this->URL_BASE.'/update_request_status';
        $response = $client->request('POST', $url, [
            'form_params' => [
                'client_id' => session('user')['client_id'],
                'token' => session('session_info')['token'],
                'business' =>'UPDATE_REQUEST_STATUS',
                'request_id' => $request['id'],
                'new_status_id' => $request['new_status']
            ]

        ]);
        $response = $response->getBody()->getContents();

//            return session('user');

        $response = json_decode($response, true);

        return back();
    }

    function show_event_details(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $url = $this->URL_BASE.'/show_event_details';
        $response = $client->request('POST', $url, [
            'form_params' => [
                'client_id' => session('user')['client_id'],
                'token' => session('session_info')['token'],
                'business' =>'UPDATE_REQUEST_STATUS',
                'event_id' => $request['id']
            ]

        ]);
        $response = $response->getBody()->getContents();

//            return session('user');

        $response = json_decode($response, true);

        return view('event_entries', ['entries' => $response]);

    }

    public function show_entry_details(Request $request)
    {

        $client = new \GuzzleHttp\Client();
        $url = $this->URL_BASE.'/show_entry_details';
        $response = $client->request('POST', $url, [
            'form_params' => [
                'client_id' => session('user')['client_id'],
                'token' => session('session_info')['token'],
                'business' =>'UPDATE_REQUEST_STATUS',
                'entry_id' => $request['entry_id']
            ]

        ]);
        $response = $response->getBody()->getContents();

//            return session('user');

        $response = json_decode($response, true);

//        return $response;

        $response[0]['pic'] = 'data:' . 'image/gif' . ';base64,'.$response[0]['pic'];

        if (sizeof($response))
        {
            return view('entry_details', ['entry' => $response[0]]);
        }
        else
        {
            return json_encode(
                [
                    'id' => 0,
                    'message' => 'no entry found'
                ]
            );
        }



    }

    public function handle_marks(Request $request)
    {

        // primary validation
        $rules = array(
            'entry_id' => 'required',
            'marks' => 'required|max:100|min:0'
        );
        $validator = Validator::make($request->all(), $rules);

        // Check to see if validation fails or passes
        if ($validator->fails())
        {
            // Redirect or return json to frontend with a helpful message to inform the user
            // that the provided file was not an adequate type
            return redirect()->back()->with('message_marks', '<p style="color: red">'.$validator->errors()->getMessages()['marks'][0].'</p>');
        }

        if ($request['marks'] > 100)
        {
            return redirect()->back()->with('message_marks', '<p style="color: red">Marks cannot be more than 100</p>');
        }

        if ($request['marks'] < 0)
        {
            return redirect()->back()->with('message_marks', '<p style="color: red">Marks is to be non negative</p>');
        }


        $client = new \GuzzleHttp\Client();
        $url = $this->URL_BASE.'/give_points';
        $response = $client->request('POST', $url, [
            'form_params' => [
                'client_id' => session('user')['client_id'],
                'token' => session('session_info')['token'],
                'business' =>'GIVE_MARK',
                'entry_id' => $request['entry_id'],
                'points' => $request['marks']
            ]

        ]);
        $response = $response->getBody()->getContents();

//            return session('user');

        $response = json_decode($response, true);

//        return $response;

        if ($response['id'])
        {
            return redirect()->back()->with('message_marks', '<p style="color: green">'.$response['message'].'</p>');
        }
        else
        {
            return redirect()->back()->with('message_marks', '<p style="color: red">'.$response['message'].'</p>');
        }

        return $request->all();
    }

    public function handle_new_entry(Request $request)
    {


        /*
         * Supposed to enter a new record in the event
         */

        // taking in
        // event_id, user_id

//        retu

        // primary validation

        $rules = array(
            'image' => 'mimes:jpeg,jpg,png,gif|required|max:1000' // max 1000kb
        );
        $validator = Validator::make($request->all(), $rules);

        // Check to see if validation fails or passes
        if ($validator->fails())
        {
            // Redirect or return json to frontend with a helpful message to inform the user
            // that the provided file was not an adequate type
            return redirect()->back()->with('message_upload', '<p style="color: red">'.$validator->errors()->getMessages()['image'][0].'</p>');
        }


        if ($request->hasFile('image')) {
            if($request->file('image')->isValid()) {

                try {
                    $file = file_get_contents($request->file('image'));
//                    return $file;
                    $image = base64_encode($file);

                    // making an api call
                    $client = new \GuzzleHttp\Client();
                    $url = $this->URL_BASE.'/insert_entry';
                    $response = $client->request('POST', $url, [
                        'form_params' => [
                            'client_id' => session('user')['client_id'],
                            'token' => session('session_info')['token'],
                            'business' =>'ADD_ENTRY',
                            'event_id' => $request['event_id'],
                            'user_id' => $request['user_id'],
                            'pic' => $image
                        ]

                    ]);

                    $response = $response->getBody()->getContents();

//            return session('user');

                    $response = json_decode($response, true);

//                    return $response;

                    if ($response['id'] == 1)
                    {
                        return redirect()->back()->with('success_photo', 'Photo Upload Complete');
                    }
                    else
                    {
                        return redirect()->back()->with('success_photo', $response['message']);
                    }



                } catch (FileNotFoundException $e) {
                    return "catch";

                }
            }
        }

        else
        {
            return "does not have a file";
        }
    }

    public function insert_new_entry(Request $request)
    {
        // finding if entry already done in this event

        $event_id = $request['event_id'];
        $user_id = session('user')['client_id'];

        // see if there is any entry


        $all_events = $this->api_call('/show_attended_events',
        [
           'user_id' => $user_id,
            'all' => true
        ]);

//        return $all_events;

        // counting total number of un attended events
        $cnt = 0;
        foreach ($all_events as $event)
        {
            if (!$event['attended'] && $event['expired'] == false)
            {
                $cnt += 1;
            }
        }




        return view('entry_details_participant', [
            'user_id' => $user_id,
            'all_events' => $all_events,
            'unattended_count' => $cnt
        ]);






//
//        if ($this->has_attended($attended, $event_id))
//        {
//            // has already attended
//            return view('entry_details_participant',
//                [
//                    'participated' => 1,
//                ]
//            );
//        }
//        else
//        {
//            // now showing marks
//
//            // first, finding the entry id
//            $entry_id = NULL;
//            foreach ($attended as $event)
//            {
//                if ($event['user_id'] == $user_id and $event['event_id'] == $event_id)
//                {
//                    $entry_id = $event['id'];
//                    break;
//                }
//            }
//
//            $entry_details = $this->api_call('/show_entry_details', [
//                'client_id' => session('user')['client_id'],
//                'token' => session('session_info')['token'],
//                'business' =>'UPDATE_REQUEST_STATUS',
//                'entry_id' => $entry_id
//            ]);
//
//            return $entry_details;
//
//            return view('entry_details_participant',
//            [
//              'participated' => 1,
//              'entry' => $entry_details
//            ]
//            );
//
//
//        }


        // if there is no entry already
        // get marks and event details

//        return view('entry_details_participant');
    }

    public function has_attended($attended_events, $target_event)
    {
        foreach ($attended_events as $event){
            if ($attended_events['id'] == $target_event)
            {
                return true;
            }
        }

        return false;
    }

    public function api_call($link, $fields)
    {
        // makes an api call
        $client = new \GuzzleHttp\Client();
        $url = $this->URL_BASE.$link;
        $response = $client->request('POST', $url, [
            'form_params' => $fields

        ]);

        $response = $response->getBody()->getContents();

        $response = json_decode($response, true);

        return $response;
    }

    public function handle_new_request(Request $request)
    {
//        return $request;

        $rules = array(
            'title' => 'required',
            'description' => 'required',
            'starting_amount' => 'numeric|required',
            'ending_amount' => 'numeric|required',
            'address' => 'required',
            'expected_deadline' => 'required'

        );



        $validator = Validator::make($request->all(), $rules);

        // Check to see if validation fails or passes
        if ($validator->fails())
        {
            // Redirect or return json to frontend with a helpful message to inform the user
            // that the provided file was not an adequate type
            foreach ($validator->errors()->getMessages() as $message)
            {
                return redirect()->back()->with('message_request', '<p style="color: red">'.$message[0].'</p>');
            }


        }

        if ($request['expected_deadline'] < Carbon::now())
        {
            return redirect()->back()->with('message_request', '<p style="color: red">Choose a date from future</p>');
        }

        if ($request['starting_amount'] >= $request['ending_amount'])
        {
            return redirect()->back()->with('message_request', '<p style="color: red">Starting amount should be less than ending amount</p>');
        }

        $response = $this->api_call('/create_request',
        [
            'client_id' => session('user')['client_id'],
            'token' => session('session_info')['token'],
            'business' => 'MAKE_NEW_REQUEST',
            'title' => $request['title'],
            'description' => $request['description'],
            'postal_address' => $request['address'],
            'amount_range_start' =>$request['starting_amount'],
            'amount_range_end' =>$request['ending_amount'],
            'expected_deadline' => $request['expected_deadline'],

            'is_delivery' => 1,
            'open_for' => 1
        ]);

//        return $response;

        if ($response['id'] == 1)
        {
//            return "reaced here";
            return redirect()->back()->with('message_request', '<p style="color: green">New entry created</p>');
        }
        else
        {
            return redirect()->back()->with('message_request')->with('<p style="color: red">'.$response['message'].'</p>');
        }

    }


    public function logout()
    {
        $this->api_call('/logout', [
            'user_id' => session('user')['client_id']
        ]);

        session()->flush();

        return redirect('/');
    }


    public function set_price(Request $request)
    {
        if ($request->has('price'))
        {
            if ($request['price'] >= 0)
            {


                $response = $this->api_call('/set_price',
                [
                    'request_id' => $request['id'],
                    'price' => $request['price']
                ]);


                if ($response['id'] == 1)
                {
                    return redirect()->back()->with('message_price', '<p style="color: green"> Work Done</p>');
                }



            }


        }
        else
        {
            return redirect()->back()->with('message_price', '<p style="color: red">Does not hae price</p>');
        }

        return redirect()->back()->with('message_price', '<p style="color: red"> something went wrong</p>');
    }

    public function accept_request(Request $request)
    {
        // user id
        // request id

//        return $request->all();

        $this->api_call('/accept_request', [
            'token' => session('session_info')['token'],
            'user_id' => session('user')['client_id'],
            'request_id' => $request['request_id'],
            'business' => 'ACCEPT_REQUEST',
        ]);



        return redirect()->back();


    }

    public function handle_create_event(Request $request)
    {

        if ($request->has('start') && $request->has('end'))
        {
            if ($request['start'] < $request['end'] && Carbon::now() <= $request['start'])
            {

            }
            else
            {
                return redirect()->back()->with('message_event', 'Starting date should be on or before current date');
            }
        }
        else
        {
            return redirect()->back()->with('message_event', 'Both starting and ending dates are required');
        }

        $response = $this->api_call('/make_new_event',
        [
            'token' => session('session_info')['token'],
            'business' => 'MAKE_NEW_EVENT',
            'starting_datetime' => $request['start'],
            'ending_datetime' => $request['end'],
            'event_name' => $request['name'],
            'description' => $request['descript']
        ]);

        if ($response['id'] == 1)
        {
            return redirect()->back()->with('message_event', '<p style="color: green">Event created</p>');
        }

        foreach($response['message'] as $message)
        {
            return redirect()->back()->with('message_event', '<p style="color: red">'.$message[0].'</p>');
        }

        return $response;

    }

    public function handle_register(Request $request)
    {

        $rules = array(
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'conf_password' => 'required',
        );

        $validator = Validator::make($request->all(), $rules);

        // Check to see if validation fails or passes
        if ($validator->fails())
        {
            // Redirect or return json to frontend with a helpful message to inform the user
            // that the provided file was not an adequate type
            foreach ($validator->errors()->getMessages() as $message)
            {
                return redirect()->back()->with('message_register', '<p style="color: red">'.$message[0].'</p>');
            }


        }

        $response = $this->api_call('/register', [
            "name" => $request['name'],
            "email" => $request['email'],
            "password" => $request['password']
        ]);

        if ($response['id'] == 1)
        {
            return redirect()->back()->with('message_register', '<p style="color: green">'.$response['message'].'</p>');
        }

        else
        {
            foreach ($response['message'] as $message)
            {
                return redirect()->back()->with('message_register', '<p style="color: red">'.$message[0].'</p>');
            }

        }

    }






}
