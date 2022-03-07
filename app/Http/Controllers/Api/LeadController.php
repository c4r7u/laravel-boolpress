<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Lead;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewContactMail;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    public function store(Request $request) {
        $data = $request->all();
        
        $validator = Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            // Errori di validazione
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ]);
        }

        // 1- salvare la nuova lead nel db
        $new_lead = new Lead();
        $new_lead->fill($data);
        $new_lead->save();

        // 2- inviare la mail al reponsabile del customer service
        Mail::to('customerservice@boolpress.it')->send(new NewContactMail($new_lead));

        return response()->json([
            'success' => true
        ]);
    }
}
