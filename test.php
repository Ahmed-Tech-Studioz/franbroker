<?php
require('wp-config.php');
global $wpdb;
	global $wpdb;
	$args = array(
	'meta_key' => 'pie_hidden_8',
	'orderby' => 'meta_value',
	'order' => 'ASC',
	'meta_query' => array(
	 'relation' => 'AND',
		array(
			'key'     => 'pie_hidden_8',
			'value'   => 'Company',
			'compare' => '='
		) ,
		array(
			'key'     => 'current_step',
			'value'   => 9,
			'compare' => '>'
		)
	),
 );

	$user_query = new WP_User_Query( $args );
	$userdata=$user_query->get_results();
	//print_r($userdata);
	$brandsearchData=array();
		
	if(is_array($userdata) && count($userdata)>0){
		foreach ( $userdata as $value){
		$pie_hidden_8=get_user_meta($value->ID,'pie_hidden_8',true);
		$current_step=get_user_meta($value->ID,'current_step',true);
		$meta=get_user_meta($value->ID,'company_admin_firstname',true);
		if($meta=''){
			$brandsearchData[$value->ID]['userid']=$value->ID;
			$brandsearchData[$value->ID]['userid']=$value->ID;
			$brandsearchData[$value->ID]['pie_hidden_8']=$pie_hidden_8;
			$brandsearchData[$value->ID]['current_step']=$current_step;
			$brandsearchData[$value->ID]['meta']=$meta;
		}
		//	update_user_meta($value->ID, 'current_step', 10);
		}
	}
	echo '<pre>';
		print_r($brandsearchData);
		echo '</pre>';
?>