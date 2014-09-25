<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Utils
 *
 * @author edinson
 */
class Utils {
    //put your code here
    
    public static function getAddress ($lat, $lng, $sensor = 'false') {
        $json = Partial::loadPage("http://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&sensor=$sensor");
        $direction = json_decode($json, true);
        $tmp = array ();

        if($direction['status'] == 'OK') {
            $dir = explode(',', $direction['results'][0]['formatted_address']);
            $_r = $direction['results'];

            $tmp['address'] = $dir[0];
            foreach ($_r as $_a) {
                foreach ($_a['address_components'] as $_b) {
                    $tmp[$_b['types'][0]] = $_b['long_name'];
                }
            }
        }
        
        return $tmp;
    }
}
