<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Contact;
use App\Http\Resources\Contact as ContactResource;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get contacts
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(5);

        // return collection of contacts as a resource
        return ContactResource::collection($contacts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $contact = $request->isMethod('put') || $request->isMethod('patch')  ? Contact::findOrFAil($request->contact_id) : new Contact;
        // Handle File Upload
        if($request->hasFile('avatar')){
            $image = $request->file('avatar');
            $name_with_extension = $image->getClientOriginalName();
            $extension = $image->getClientOriginalExtension();
            $file_name = pathinfo($name_with_extension, PATHINFO_FILENAME);
            $tmp_path = $image->getPathName();

            $folder = 'images/';
            $full_file_name = $file_name.'_'.time().'.'.$extension;
            $new_path = public_path($folder).$full_file_name;

            File::move($tmp_path, $new_path);

            $fileNameToStore = 'images/'.$full_file_name;

        } else {
            $fileNameToStore = 'images/dummy-avatar.jpg';
        }

        $contact->id = $request->input('contact_id');
        $contact->group_id = $request->input('group_id');
        $contact->first_name = $request->input('first_name');
        $contact->last_name = $request->input('last_name');
        $contact->address = $request->input('address');
        $contact->city = $request->input('city');
        $contact->zip = $request->input('zip');
        $contact->country = $request->input('country');
        $contact->email = $request->input('email');
        $contact->phone = $request->input('phone');
        $contact->note = $request->input('note');
        $contact->avatar = $fileNameToStore;

        if($contact->save()) {
            return new ContactResource($contact);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get contact
        $contact = Contact::findOrFail($id);

        // Return single contact as a resource

        return new ContactResource($contact);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get contact
        $contact = Contact::findOrFail($id);

        File::delete($contact->cover_image);
        // Return deleted contact as a resource
        if($contact->delete()) {
            return new ContactResource($contact);
        }
    }
}
