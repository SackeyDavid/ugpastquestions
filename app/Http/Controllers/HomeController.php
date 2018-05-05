<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Controller;
use App\PastQuestions;
use App\Http\Requests;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pasquos = PastQuestions::where('uploaded_by', Auth::user()->id);

        return view('home')->withPasquos($pasquos);
    }

    public static function convert_from_latin1_to_utf8_recursively($dat)
    {
        if (is_string($dat))
            return utf8_encode($dat);
        if (!is_array($dat))
            return $dat;
        $ret = array();
        foreach ($dat as $i => $d)
            $ret[$i] = self::convert_from_latin1_to_utf8_recursively($d);
        return $ret;
    }


    public function upload(Request $request)
    {
        
    
        $input['uploaded_by'] = $request->user()->id;

        $striped_content = '';
        $department = 'department';
        $semester = '/\bfirst\s*semester\b/i';
        $dictionary = array("school","college");
        $year = "/\b\d{4}\/\d{4}\b/";
        $course_code = "/\b[A-Z]{4}\s*\d\d\d\b/";

        if($request->hasFile('file'))
        {
            $file = $request->file('file');

            $filename = $file->getClientOriginalName();

            /*File::make($path)->save(public_path('/uploads/' . $filename));*/

            $file->move('uploads', $filename);
            $filePath = public_path("uploads/$filename");

            $trimmed = file($filePath);

            $input['path'] = $filename;

            $file_parts = pathinfo($filename);

            switch($file_parts['extension'])
            {
                case "doc":
                $fileHandle = fopen($filePath, "r");
                $line = @fread($fileHandle, filesize($filePath));   
                $lines = explode(chr(0x0D),$line);
                $content = "";
                foreach($lines as $thisline)
                  {
                    $pos = strpos($thisline, chr(0x00));
                    if (($pos !== FALSE)||(strlen($thisline)==0))
                      {
                      } else {
                        $striped_content .= $thisline." ";
                      }
                  }
                 $striped_content = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$striped_content);
                 $matches = array_filter($lines, function($var) use ($searchword) { 
                    return preg_match("/\b$searchword\b/i", $var); });
                 PastQuestions::create($input);
                 return $this->convert_from_latin1_to_utf8_recursively($matches); 
                

                case "docx":
                $content = '';

                $zip = zip_open($filePath);

                if (!$zip || is_numeric($zip)) return false;

                while ($zip_entry = zip_read($zip)) {

                    if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

                    if (zip_entry_name($zip_entry) != "word/document.xml") continue;

                    $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

                    zip_entry_close($zip_entry);
                }// end while

                zip_close($zip);

                $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
                $content = str_replace('</w:r></w:p>', "\r\n", $content);
                $striped_content = strip_tags($content);
                $array = explode("\n", $striped_content);
                //$example = array('An example','Another example','Last example');
                $matches=  array_filter($array, function($var) use ($department) { return preg_match("/\b$department\b/i", $var); });

                $semester_toDb = array_filter($array, function($var) use ($semester) { return preg_match("$semester", $var); });

                $semester_string = current($semester_toDb);

                if (preg_match($semester, $semester_string, $matches)) {

                    $input['semester'] = $matches[0];
                }else
                {
                    $input['semester'] = "SECOND SEMESTER"; 
                }

                //$todB = array_values($matches);
                if (current($matches) == 0) {
                   $input['department'] = ""; 
                }else
                {
                    $input['department'] = current($matches);
                }

                $year_to_Db = array_filter($array, function($var) use ($year) { return preg_match("$year", $var); });

                $year_string = current($year_to_Db);
                if (preg_match($year, $year_string, $matches)) {
                    $input['year'] = $matches[0];
                }

                $course_code_toDb = array_filter($array, function($var) use ($course_code) { return preg_match("$course_code", $var); });
                $course_code_and_title = current($course_code_toDb);

                if(preg_match($course_code, $course_code_and_title, $match)) 
                {
                   $input['course_code'] = $match[0];
                   //preg_match_all('!\d+!', $match[0], $findlevel);
                   preg_match("/([0-9]+)/", $match[0], $findlevel);

                   if ($findlevel[1][0] == 4) {

                       $input['level'] = '400';
                   } 
                   elseif ($findlevel[1][0] == 3) {

                       $input['level'] = '300';
                   } 
                   elseif ($findlevel[1][0] == 2) {

                       $input['level'] = '200';
                   } 
                   else  
                   {

                       $input['level'] = '100';
                   }
                   

                 
                   
                } 
                else 
                {
                  return "We found no match.";
                }

                if (($pos = strpos($course_code_and_title, ":") !== FALSE || ($pos = strpos($course_code_and_title, "-")) !== FALSE)) 
                { 
                    $input['course_title'] = substr($course_code_and_title, $pos+8); 
                }

                /*foreach ($dictionary as $searchword)
                {
                    

                    array_push($matches, array_filter($array, function($var) use ($searchword) { return preg_match("/\b$searchword\b/i", $var); }));
                }*/ 
                PastQuestions::create($input);
                return $input;



                
   
            }


        }

        
        
        
        
    }

    
}
