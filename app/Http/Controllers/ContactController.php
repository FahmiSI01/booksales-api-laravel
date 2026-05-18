<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::all();

        if ($contacts->isEmpty()) {
            return response()->json([
                'success' => true,
                'message' => 'No Resources Found',
            ], 200);
        }

        return response()->json([
            'success' => true,
            'message' => 'Get All Resources',
            'data' => $contacts,
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'nullable|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $contact = Contact::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'status' => 'unread',
            'read_by_user' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Contact created successfully',
            'data' => $contact,
        ], 201);
    }

    public function show(string $id)
    {
        $contact = Contact::find($id);

        if (! $contact) {
            return response()->json([
                'success' => false,
                'message' => 'Resource Not Found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Resource',
            'data' => $contact,
        ], 200);
    }

    public function update(Request $request, string $id)
    {
        $contact = Contact::find($id);

        if (! $contact) {
            return response()->json([
                'success' => false,
                'message' => 'Resource Not Found',
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'sometimes|nullable|exists:users,id',
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|max:255',
            'subject' => 'sometimes|required|string|max:255',
            'message' => 'sometimes|required|string',
            'reply' => 'sometimes|nullable|string',
            'status' => 'sometimes|required|string',
            'read_by_user' => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $contact->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Contact updated successfully',
            'data' => $contact,
        ], 200);
    }

    public function destroy(string $id)
    {
        $contact = Contact::find($id);

        if (! $contact) {
            return response()->json([
                'success' => false,
                'message' => 'Resource Not Found',
            ], 404);
        }

        $contact->delete();

        return response()->json([
            'success' => true,
            'message' => 'Delete resource successfully',
        ], 200);
    }
}
