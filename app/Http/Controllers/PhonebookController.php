<?php

namespace App\Http\Controllers;

use App\Models\phonebook;
use Illuminate\Http\Request;

class PhonebookController extends Controller
{
    public function addContact(Request $request)
    {
        if (empty($request->firstname) || empty($request->lastname) || empty($request->phone_number)){
            return Response()->json([
                "success" => 'false',
            ]);
        }else{
            $phonebook = [];
            $phonebook['firstname'] = $request->firstname;
            $phonebook['lastname'] = $request->lastname;
            $phonebook['contact'] = $request->phone_number;
            $results = phonebook::create($phonebook);
            if($results){
                return Response()->json([
                    "success" => 'true',
                ]);
            }
        }

    }

    public function contacts(Request $request)
    {
        if (empty($request->search_contact)){
            $phone_book_contacts['phone_book_contacts'] =  phonebook::orderBy('id','DESC')->get();
        }elseif (!empty($request->search_contact)){
            $phone_book_contacts['phone_book_contacts'] =  phonebook::orderBy('id', 'DESC')->where('lastname',$request->search_contact)->get();
        }
       return view('dashboard')->with($phone_book_contacts);
    }

    public function updateContact(Request $request)
    {
        if (empty($request->edit_firstname) || empty($request->edit_lastname) || empty($request->edit_contact)){
            return Response()->json([
                "success" => 'false',
            ]);
        }else{
            $phonebook  = phonebook::where('id',$request->contact_id)->first();
            $phonebook->firstname = $request->edit_firstname;
            $phonebook->lastname = $request->edit_lastname;
            $phonebook->contact = $request->edit_contact;
            $results = $phonebook->save();
            if($results){
                return Response()->json([
                    "success" => 'true',
                ]);
            }
        }

    }


    public function deleteContact(Request $request)
    {
            $results  = phonebook::where('id',$request->delete_contact_id)->delete();
            if($results){
                return Response()->json([
                    "success" => 'true',
                ]);
            }

    }
}
