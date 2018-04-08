<?php

namespace App\Http\Controllers\API;

use App\Models\Contact;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function store(ContactRequest $request)
    {
        $data = $request->all();

        $contact = Contact::create($data);

        return response()->json(['success' => (boolean)$contact], 200);
    }
}
