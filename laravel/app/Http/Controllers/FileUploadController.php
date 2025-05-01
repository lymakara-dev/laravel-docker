<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        // Validate the uploaded file
        $request->validate([
            'document' => 'required|file|mimes:jpg,png,pdf|max:2048', // Adjust rules as needed
        ]);

        // Store the file in the 'uploads' directory
        $path = $request->file('document')->store('uploads', 'public');

        // Return success response
        return back()->with('success', 'File uploaded successfully!')->with('file', $path);
    }
}
