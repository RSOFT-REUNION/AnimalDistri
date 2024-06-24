<?php

use App\Imports\CatalogProductImport;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

Schedule::call(function (Request $request) {
    // Retrieve the file contents from storage
    $fileContents = Storage::disk('ftp_files')->get('Import_product.csv');
    // Create a temporary file path
    $tempFilePath = tempnam(sys_get_temp_dir(), 'Import_product');
    // Write the retrieved file contents into the temporary file
    file_put_contents($tempFilePath, $fileContents);
    // Transform the temporary file into an UploadedFile object
    $uploadedFile = new UploadedFile(
        $tempFilePath,
        'Import_product.csv', // Original file name
        'text/csv', // Mime type of the file
        null, // File size, null to let PHP handle it
        true // Whether the file should be moved to the final destination
    );
    // Set the file in the request object
    $request->files->set('file', $uploadedFile);
    // Example of using dd() to inspect the transformed file in $request
    $Import_product = $request->file;
    Excel::import(new CatalogProductImport(), $Import_product);
})->name('import_product_job')->daily()->withoutOverlapping();
