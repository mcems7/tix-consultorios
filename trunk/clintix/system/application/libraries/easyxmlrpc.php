<?php
class Easyxmlrpc {

    // hacky function to detect if it's a sequential array or an associative array
    // array_is_associative()
    function _array_is_associative ($array)
    {
        if ( is_array($array) && ! empty($array) )
        {
            for ( $iterator = count($array) - 1; $iterator; $iterator-- )
            {
                if ( ! array_key_exists($iterator, $array) ) { return true; }
            }
            return ! array_key_exists(0, $array);
        }
        return false;
    }
    // This function is used inside getXMLRPCdata()
    // arrays for XML-RPC convert normal data to strings, but need
    //  array structure. 
    function _getArrayValue($data) {
        if (is_array($data)) {
            return $this->convert_response($data);
        }
        else {
            return $data;
        }
    }
    // This function takes a value, array, or nested array and reconstructs it into 
    //   an array structure that CI's XML-RPC libraries like.
    // Sequentially indexed arrays are returned as lists unless $onlystruct is provided and
    //   then they'll be constructed as structs with the key as a string (e.g. '1' => 'myvalue')
    function convert_response($data, $onlystruct=FALSE) {
        if (is_int($data)) {
            return array($data, 'int');
        }
        if (is_string($data)) {
            return array($data, 'string');
        }
        if (is_array($data)) {
            $outputform = 'struct';
            $temporary = array(); 
            $assoc =  $this->_array_is_associative($data);
            foreach($data as $key => $value) {
                if (!$assoc AND !$onlystruct) {
                    $outputform = 'array';
                    $temporary[] = $this->_getArrayValue($value);
                }
                else {
                    $outputform = 'struct';                    
                    $temporary[$key] = $this->convert_response($value);
                }
            }
            return (array($temporary, $outputform));
        }
        // TODO: Support more types maybe?
        //* boolean
        //* double
        //* dateTime.iso8601
        //* base64
        return array("_".strval($data), 'string');
    }
}
?>  