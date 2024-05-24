<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public static function upload($image, $folderName)
    {
        // Retrieve the original filename without extension
        $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
    
        // Clean up the file name to avoid filesystem issues and ensure uniqueness
        $safeName = preg_replace('/[^a-zA-Z0-9_-]/', '', $originalName);
    
        // Append a timestamp to the filename to avoid conflicts with existing files
        $timestamp = now()->format('YmdHisu');
    
        // Combine parts to form the final filename
        $fileName = $safeName . '_' . $timestamp . '.' . $image->getClientOriginalExtension();
    
        // Store the image in the specified folder within the public disk
        $image->storeAs($folderName, $fileName, 'public');
    
        // Return the path where the image was stored
        return $folderName . '/' . $fileName;
    }

 

    public function downloadImage(Request $request)
    {
        $imageUrl = $request->input('imageUrl');

        // Validate the image URL
        if (!$imageUrl) {
            return response()->json(['error' => 'Image URL is missing'], 400);
        }

        // Download the image
        $imageContent = @file_get_contents($imageUrl);

        // Check if image download failed
        if ($imageContent === false) {
            return response()->json(['error' => 'Failed to download image'], 500);
        }

        // Generate a unique filename for the saved image
        $filename = 'image_' . Str::random(10) . '.jpg'; // Adjust extension as per image type

        // Save the image to local storage
        Storage::put('public/images/' . $filename, $imageContent);

        // Set the headers for the download
        $headers = [
            'Content-Type' => 'image/jpeg', // Change this according to your image type
            'Content-Disposition' => 'attachment; filename="image.jpg"', // Change the filename if needed
        ];

        // Return the image as a download response
        return response()->streamDownload(function () use ($imageContent) {
            echo $imageContent;
        }, 200, $headers);
    }


}
