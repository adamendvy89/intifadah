<?php

    define('BASEPATH', str_replace("\\", "/", 'http://intifadah.dev/'));

    function save_online_meeting($postdata, $primary)
    {
    	//var_dump($postdata);
    	$postdata->set('created_at', date("Y-m-d h:i:s"));
        $postdata->set('slug', format_uri_slug($postdata->get('room_name')));
    }

    function save_donation($postdata, $primary)
    {
        
        $postdata->set('amount', str_replace(".", "", $postdata->get('amount')));
    }

    function format_uri_slug( $string, $separator = 'x' )
    {
        $accents_regex = '~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i';
        $special_cases = array( '&' => 'and', "'" => '');
        $string = mb_strtolower( trim( $string ), 'UTF-8' );
        $string = str_replace( array_keys($special_cases), array_values( $special_cases), $string );
        $string = preg_replace( $accents_regex, '$1', htmlentities( $string, ENT_QUOTES, 'UTF-8' ) );
        $string = preg_replace("/[^a-z0-9]/u", "$separator", $string);
        $string = preg_replace("/[$separator]+/u", "$separator", $string);
        return $string;
    }

    function nice_input_jumlah_uang($value, $field, $primary_key, $list, $xcrud)
    {

        $html = '<script>'
        .'function addDecimalPoints(el) {
            var inputElement = el;
            inputElement.value=inputElement.value.replace(/\D/g, "");
            var inputValue = inputElement.value.replace(".", "").split("").reverse().join(""); // reverse
            var newValue = "";
            for (var i = 0; i < inputValue.length; i++) {
                if (i % 3 == 0) {
                    newValue += ".";
                }
                newValue += inputValue[i];
            }
            inputElement.value = newValue.split("").reverse().join("");
        }'
        .'</script>';
        
        $html .= '
        <div class="input-prepend input-append">'
        . '<input type="text" onkeyup="addDecimalPoints(this)" name="'.$xcrud->fieldname_encode($field).'" value="" class="xcrud-input" />'
            . '</div>';
        
        return $html;
            
            
    }
