<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DownloadController extends Controller
{
   public function file($file)
{
    $file = urldecode($file);

    $profile = \App\Models\UserProfile::where('logo_path', $file)
        ->orWhere('bpl_path', $file)
        ->orWhere('dti_path', $file)
        ->firstOrFail();

    $originalName = $profile->logo_path === $file ? $profile->logo_original_name
        : ($profile->bpl_path === $file ? $profile->bpl_original_name
        : $profile->dti_original_name);

    return Storage::disk('public')->download($file, $originalName);
}


}
