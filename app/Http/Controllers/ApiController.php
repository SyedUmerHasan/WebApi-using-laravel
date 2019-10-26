<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mobile;
use Whoops\Handler\XmlResponseHandler;

class ApiController extends Controller
{
    //
    public function umer(Request $request)
    {
        $requestContentType = $_SERVER['HTTP_ACCEPT'];
        $rawData = Mobile::all();
		if(strpos($requestContentType,'application/json') !== false){
            return response()->json($rawData);
		} else if(strpos($requestContentType,'text/html') !== false){
            $myHTML = "<table>";

            foreach ($rawData as $eachObj) {
                $myHTML = $myHTML . "<tr> <td>" .  ($eachObj["id"]) .  ") </td>" . "<td>" .  ($eachObj["mobilename"]) .  "</td>" . " </tr>" ;
            }
            $myHTML = $myHTML . "</table>";

            return response($myHTML)->header('Content-Type', 'text/html');
        }
        else if(strpos($requestContentType,'text/xml') !== false){
            $myXML = '<listofrecords  xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns="http://www.cpandl.com">';

            foreach ($rawData as $eachObj) {
                $myXML = $myXML . "<eachrecord> <id>" .  ($eachObj["id"]) .  ") </id>" . "<mobilename>" .  ($eachObj["mobilename"]) .  "</mobilename>" . " </eachrecord>" ;
            }
            $myXML = $myXML . '</listofrecords>';

            return response($myXML)->header('Content-Type', 'text/xml');
        }
        return $requestContentType;
    }




}
