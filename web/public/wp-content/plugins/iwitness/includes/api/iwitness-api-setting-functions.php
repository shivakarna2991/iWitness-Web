<?php

/**
 * Get plans setting
 * @return array
 */
function iwitness_get_plans()
{
    $response = iwitness_api_get('/plan', array());
    $response = $response['_embedded']['plan'];

    $plans = array();
    foreach ($response as $res) {
      	
      if(!isset($res['member_price'])) {
          $res['member_price'] = 0.00;
        	if($res['name'] == 'month' ) {
          	$res['member_price'] = 1.99;
          } else if($res['name'] == 'year') {
          	$res['member_price'] = 19.99; 
          } else {
            $res['member_price'] = 0.00;
          }
        
        }
        $plans[$res['key']] = array('price' => $res['price'],'member_price' => $res['member_price'], 'length' => $res['length']);
    }
    return $plans;
}
