<?php 

if(! function_exists('get_times')){
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

