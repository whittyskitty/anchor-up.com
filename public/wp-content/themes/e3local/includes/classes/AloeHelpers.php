<?php 

class AloeHelpers {

    public static function front_end_error($message="ERROR: ", $dir=__DIR__, $line=__LINE__){
        $message = "ERROR: ".$message;
        $bt =  debug_backtrace();
        $message .= " FILE:'" .$bt[0]['file']. "'.\n LINE: '" .$bt[0]['line']. "'.\n";
        return $message;
    }
}
