<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PastQuestions;
use App\Http\Requests;
use Auth;
use Pagination;

class ServiceController extends Controller
{
    //
    public function search(Request $request)
    {
        $search_item = $request->searchinput;

        if($request->ajax())
        {
            
            $output = "";
            $pasquos = PastQuestions::where('course_code', 'LIKE', '%'.$search_item.'%')->orWhere('course_title', 'LIKE', '%'.$search_item.'%')->orWhere('path', 'LIKE', '%'.$search_item.'%')->paginate(2); 

        	return view('searchresults', compact('pasquos','search_item'))->render();

			
		}

    }
   
}
