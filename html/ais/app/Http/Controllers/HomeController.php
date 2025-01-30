<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Sentence;

class HomeController extends Controller
{
    public function index()
    {
        $log = Log::all();

        $parameters = array(
            'log' => $log
        );
        return view('backend.index', $parameters);
    }

    public function menu($names)
    {
        $log = Log::all();

        $parameters = array(
            'name' => $names,
            'log' => $log
        );
        return view('backend.index', $parameters);
    }

    public function nmea()
    {
        $sentences = Sentence::where('hwid', null)->first();

        echo $sentences->nmea;
    }

    public function nmeaID($ids)
    {
        $isavail = Sentence::where('hwid', $ids)->count();
        if($isavail>0)
        {
            $sentences = Sentence::where('hwid', $ids)->first();

            echo $sentences->nmea;
        }
        else
        {
            return abort(404);
        }
    }

    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'sentence'     => 'required|min:20',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        if (strpos(strval($request->sentence), "identity") !== false || strpos(strval($request->sentence), "form-urlencoded") !== false)
        {
            //do nothing
        }
        else
        {
            if(strlen(strval($request->sentence)) < 10)
            {
                //do nothing
            }
            else
            {
                //create post
                $count = Sentence::where('hwid', null)->count();
                if ($count == 0) {
                    $post = Sentence::create([
                        'nmea'     => $request->sentence,
                    ]);
                } else {
                    $update = Sentence::where('hwid', null)->update([
                        'nmea' => $request->sentence,
                    ]);
                }

                $result = json_encode(array('success' => true, 'msg' => $request->sentence));
                return "ok";  
            }
        }
    }

    public function storeID(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'sentence'     => 'required|min:20',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }


        if (strpos(strval($request->sentence), "identity") !== false || strpos(strval($request->sentence), "form-urlencoded") !== false)
        {
            //do nothing
        }
        else
        {
            if(strlen(strval($request->sentence)) < 10)
            {
                //do nothing
            }
            else
            {
                //create post
                $count = Sentence::where('hwid', $request->hwid)->count();
                if ($count == 0) {
                    $post = Sentence::create([
                        'nmea'     => $request->sentence,
                        'hwid'     => $request->hwid,
                    ]);
                } else {
                    $update = Sentence::where('hwid', $request->hwid)->update([
                        'nmea' => $request->sentence,
                        'hwid'     => $request->hwid,
                    ]);
                }

                $result = json_encode(array('success' => true, 'msg' => $request->sentence));
                return "ok";  
            }
        }
    }

    public function storeJSON(Request $request)
    {
        $nmea = $request['nmea'];

        $result = json_encode(array('success' => true, 'msg' => $nmea));

        return "ok";
    }
}
