<?php

use Illuminate\Support\Facades\Storage;

if (! function_exists('get_times')) {
    function get_times( $default = '19:00', $interval = '+30 minutes' ) {

        $output = '';

        $current = strtotime( '00:00' );
        $end = strtotime( '23:59' );
        $output = "<option value=''>Select</option>";
        while( $current <= $end ) {
            $time = date( 'H:i', $current );
            //$sel = ( $time == $default ) ? ' selected' : '';
            $sel = ( $time == $default ) ? ' ' : '';
            $output .= "<option value=\"{$time}\"{$sel}>" . date( 'h.i A', $current ) .'</option>';
            $current = strtotime( $interval, $current );
        }

        return $output;
    }
}

if (! function_exists('fileUpload')) {
    function fileUpload( $fileName ) {
        try {
            // Handle File Upload
            if (request()->hasFile($fileName)) {
                // Get filename with extension
                $filenameWithExt = request()->file($fileName)->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                // Get just ext
                $extension = request()->file($fileName)->getClientOriginalExtension();
                //Filename to store
                $fileNameToStore = $filename . '_' . time() . '.' . $extension;

                $filePath = "uploads/" . $fileNameToStore;
                $exists = Storage::exists($filePath);
                if (!$exists) {
                    Storage::put($filePath, file_get_contents(request()->file($fileName)), 'public');
                }
                $file_url = $filePath;

                return $file_url;
            } else {
                return 'File doesn\'t exist';
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}

if (! function_exists('fileUrl')) {
    function fileUrl($path = null)
    {
        return 'https://s3.'.env('AWS_DEFAULT_REGION').'.amazonaws.com/'.env('AWS_BUCKET').'/'.$path;
    }
}

