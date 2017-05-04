<?php
/**
 * Template Name: Company Landing
 *
 * @package FRAN Broker
 */
// Exit if accessed directly
if (!defined('ABSPATH'))
    exit;
global $themename;
global $shortname;
$errors = array();
$edit_base = array();
$empty_answer = "N/A";

if (is_user_logged_in()) {
	//is_super_admin(get_current_user_id()) && 
	if(isset($_REQUEST['company_userid']) && !empty($_REQUEST['company_userid'])){
		$fr_user_id = $_REQUEST['company_userid'];
		$edit_base['company_userid'] = $_REQUEST['company_userid'];
	}else{
		$fr_user_id = get_current_user_id();
	}

    $user_type = get_user_meta($fr_user_id, 'pie_hidden_8', true);
    if ($user_type != false && $user_type == 'Company') {
        //do something if needed
    }elseif($user_type !=false && $user_type=='Company_user'){
		$get_parent_id=get_user_meta( get_current_user_id(), '_company_parent_id', true );
		$fr_user_id = $get_parent_id;
		$company_user=true;
		
	}else {
        //Not enough permission for company page
        $errors[] = 'You do not have enough permission to access this page';
    }
} else {
    $company_login = get_option($shortname . "_company_login", home_url());
    wp_redirect($company_login);
    exit;
}

require_once('aq_resizer.php');
//$fr_user_id = 89;
$sales_member_page = get_option($shortname . "_company_sales_contact_member", home_url());
$company_portal_url = get_option($shortname . "_company_portal", home_url());
$company_print_url = get_option($shortname . "_company_pdf", home_url());
$company_edit_url = get_option($shortname . "_company_edit", home_url());

$company_thumb_width = get_option($shortname . "_company_thumb_width",200);
$sales_contact_thumb_width = get_option($shortname . "_sales_contact_thumb_width",200);
$info = array();
$broker_info = array();
$assigned_broker = getAssignedBroker($fr_user_id);
$assigned_brand = getAssignedBrand($fr_user_id);

if($assigned_broker != false){
	if (isset($broker_fields) && is_array($broker_fields) && count($broker_fields) > 0) {
		foreach ($broker_fields as $user_meta_key) {
			$broker_info[$user_meta_key] = get_user_meta($assigned_broker, $user_meta_key, true);
		}//End foreach broker_fields
	}
}
if($assigned_brand != false){
	if (isset($assigned_brand) && is_array($assigned_brand) && count($assigned_brand) > 0) {
		foreach ($assigned_brand as $brand_id) {
			$brand_info[] = get_user_meta($brand_id->brand_id,'gerneral_brand_name', true);
		}//End foreach broker_fields
	}
}


if (isset($company_feilds) && is_array($company_feilds) && count($company_feilds) > 0) {
    foreach ($company_feilds as $user_meta_key) {
        $info[$user_meta_key] = get_user_meta($fr_user_id, $user_meta_key, true);
    }//End foreach company_feilds
}


//print_r($info);
?>
<?php get_header(); 
	if($company_user==true){
	?>
	<style type="text/css">
		.rb_edit_button{display:none;}
		</style>
	<?php
	}
?>
<style type="text/css">
@media print {
	#main-header, nav, footer,.company_infoZone img,a.btn,.et-fixed-header {
		display: none !important;
	}
	.et_pb_section{
		margin-top:-150px !important
	}
	.rb_company_landing .welcome{
		text-align: center;
	}
	a:after {
		content: " (" attr(href) ")";
		font-size: 80%;
	}
	.welcome h2{
		/* text-align: center; */
	}
}
</style>
<div id="main-content">
    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <div class="entry-content">
            <div class="et_pb_section" style="margin-top:65px;">
                <div class="et_pb_row">
                    <div class="et_pb_column et_pb_column_4_4">
                        <hr style="height:5px;" class="et_pb_space">
                        <div class="et_pb_text et_pb_bg_layout_light et_pb_text_align_left">
                            <div class="piereg_container company_infoZone">

                                <div class="rb_company_landing">
                                    <div class="row welcome_row">
                                        <div class="col-sm-12 col-md-6 welcome"><h2>Welcome <?php
                                                if (isset($info['gerneral_brand_name']) && ($info['gerneral_brand_name']) != '') {
                                                    echo $info['gerneral_brand_name'];
                                                } else {
                                                    echo $empty_answer;
                                                }
                                                ?></h2>
										</div>
                                        <div class="col-sm-12 col-md-6 welcome welcome_rightsection text-right">
                                           
											<a class="btn btn-primary btn-md" href="<?php echo $company_portal_url;?>" role="button">Return to Portal Homepage</a><br/>
											<div class="col-sm-7">
										<?php 
                                            $dbDate = get_user_meta($fr_user_id, 'pie_date_26', true);
											$companyPayOnPlacement = get_user_meta($fr_user_id, 'pie_radio_33', true);
											$affiliatesPays = get_user_meta($fr_user_id, 'pie_radio_34', true);
											if(!empty($dbDate)){
												$dbDate = getDateFromArray($dbDate);
												$dbDate = strtotime($dbDate);
											}
												$currentDate = date("Y-m-d"); 
											$currentDate = strtotime($currentDate);

											if ($dbDate > $currentDate && $dbDate!='' && $dbDate!='N/A')
											{
											    echo '<span style="color:gold;font-size:60px;text-align:right;font-size: 100px;text-align: right;line-height: 1px;margin-top: 45px;    height: 0px;    top: 45px;    position: relative;">&deg;</span>';
											}elseif($dbDate < $currentDate && $dbDate!='' && $dbDate!='N/A'){
												echo '<span style="color:red;font-size:60px;text-align:right;font-size: 100px; text-align: right; line-height: 1px; margin-top: 45px;  height: 0px;   top: 45px;position: relative;">&deg;</span>';											}
											    echo  '&nbsp;';
											if($companyPayOnPlacement[0] == 1){
												echo '<span style="color:silver;font-size:60px;text-align:right;font-size: 100px; text-align: right;line-height: 1px;  margin-top: 58px;height: 0px;    top: 45px;    position: relative;">&deg;</span>';
											}
											
											if($affiliatesPays[0] == 1){
									         	echo '<span style="color:black;font-size:60px;text-align:right;font-size: 100px;text-align: right;line-height: 1px; margin-top: 58px;height: 0px;    top: 45px;    position: relative;">&deg;</span>';											
											    
											}

                                        ?>
                                        </div>
                                        <div class="col-sm-5">
											<a class="btn btn-info btn-md btn-print" onclick="window.print();" target="_blank" role="button">Print Page</a>
											<?php if(isset($_REQUEST['company_userid']) && $_REQUEST['company_userid'] != ""){ ?>
											    <a class="btn btn-info btn-md btn-print" href="<?php echo $company_print_url.'?company_userid='.$_REQUEST['company_userid'];?>" target="_blank" role="button">View PDF</a>										
											<?php }else{ ?>
											    <a class="btn btn-info btn-md btn-print" href="<?php echo $company_print_url;?>" target="_blank" role="button">View PDF</a>										
											<?php } ?>
									   </div>
										</div>										
                                    </div >

                                    <div class="row rb_company_landingrow">

                                        <div class="col-sm-5 col-md-4 rb_landingleft_row rb_landingleft_row_height">
                                            <div class="row">
                                                <div class="col-sm-12 col-md-12">
                                                    <p class="text-right rb_edit_button">
														<?php
														$edit_base['current_step']=1;
														$company_edit=getCompanyEditlink($company_edit_url,$edit_base);
														?>
                                                        <a class="btn btn-info btn-sm" href="<?php echo $company_edit; ?>" role="button">Edit</a>
                                                    </p>
                                                </div>
                                                <div class="col-sm-12 col-md-12">
                                                    <p class="rb_company_heading">Brand</p>
													<?php
                                                        if (isset($info['gerneral_brand_name']) && ($info['gerneral_brand_name']) != '') {
														?>
                                                    <p class="rb_company_input_data text_cap">
                                                         <?php   echo $info['gerneral_brand_name'];?>
                                                    </p>
													<?php
													 }
                                                     ?>
                                                   
                                                        <?php if (isset($info['gerneral_company_logo']) && ($info['gerneral_company_logo']) != '') { 
															echo '<p class="rb_company_input_data">';
																$companyimage_attributes = wp_get_attachment_image_src( $info['gerneral_company_logo'], 'full' );
																if(is_array($companyimage_attributes) && $companyimage_attributes[1] < $company_thumb_width){ ?>																
																	<img class="img-thumbnail img-responsive full-image" src="<?php echo wp_get_attachment_url($info['gerneral_company_logo']); ?>">															
																<?php }else{ ?>
																	<img class="img-thumbnail img-responsive" src="<?php echo aq_resize(wp_get_attachment_url($info['gerneral_company_logo']), $company_thumb_width); ?>">																
															<?php } 
															echo '</p>';
															}
														?>
                                                   
                                                </div>
                                                <div class="col-sm-12 col-md-12">
                                                    <div class="row"></div>
                                                </div>
                                                <div class="col-sm-12 col-md-12">
                                                    <p class="rb_company_heading">Company</p>
                                                        <?php
                                                        if (isset($info['legal_nameOfCompany']) && ($info['legal_nameOfCompany']) != '') {
															echo '<p class="rb_company_input_data text_cap">';
                                                            echo $info['legal_nameOfCompany'];
															echo '</p>';
                                                        } 
                                                        ?>
                                                    
                                                    
                                                        <?php
														if ((isset($info['legal_companyStreetAddress']) && ($info['legal_companyStreetAddress']) != '')||(isset($info['legal_companySuiteNo'])&& ($info['legal_companySuiteNo']) != '')) {
															echo '<p class="rb_company_input_data">';
															if (isset($info['legal_companyStreetAddress']) && ($info['legal_companyStreetAddress']) != '') {
																echo $info['legal_companyStreetAddress'];
															}
															?><?php
															if (isset($info['legal_companySuiteNo']) && ($info['legal_companySuiteNo']) != '') {
																echo ', ' . $info['legal_companySuiteNo'];
															}
															echo '</p>';
														}
                                                        ?>
                                                   
                                                        <?php
														 if ((isset($info['legal_companyState']) && ($info['legal_companyState']) != '')|| (isset($info['legal_companyZipcode']) && ($info['legal_companyZipcode']) != '')){
															 echo ' <p class="rb_company_input_data">';
																if (isset($info['legal_companyCity']) && ($info['legal_companyCity']) != '') {
																	echo $info['legal_companyCity'].', ';
																}															
																if (isset($info['legal_companyState']) && ($info['legal_companyState']) != '') {
																	echo getStateText($info['legal_companyState']);
																}
																if (isset($info['legal_companyZipcode']) && ($info['legal_companyZipcode']) != '') {
																	echo ' '.$info['legal_companyZipcode'];
																}																	
															 echo '</p>';	
														}
                                                        ?>													
                                                        <?php
                                                        if (isset($info['gerneral_primary_phone_number']) && ($info['gerneral_primary_phone_number']) != '') {
															echo '<p class="rb_company_input_data">';
																echo $info['gerneral_primary_phone_number'];
																if(isset($info['gerneral_primary_phone_number_ext']) && ($info['gerneral_primary_phone_number_ext']) != '') {
																	echo ' x'.$info['gerneral_primary_phone_number_ext'];
																}																
															echo '</p>';
                                                        }
                                                        ?>
                                                    
                                                    <p class="rb_company_input_data">   
														<span class="rb_company_input_head"> Brand URL:</span>
														<?php
															if (isset($info['gerneral_brand_website']) && ($info['gerneral_brand_website']) != '') {
																echo '<a href="' . $info['gerneral_brand_website'] . '" target="_blank">' . $info['gerneral_brand_website'] . '</a>';
															} else {
																echo $empty_answer;
															}
														?>
														</span>
													</p>
													
                                                    <p class="rb_company_input_data">
														<span class="rb_company_input_head"> Company URL: </span><?php
                                                        if (isset($info['gerneral_company_website']) && ($info['gerneral_company_website']) != '') {
                                                            echo '<a href="' . $info['gerneral_company_website'] . '" target="_blank">' . $info['gerneral_company_website'] . '</a>';
                                                        } else {
                                                            echo $empty_answer;
                                                        }
                                                        ?>
													</p>

                                                    <p class="rb_company_input_data">
														<span class="rb_company_input_head"> Broker URL: </span><?php
                                                        if (isset($info['gerneral_broker_website']) && ($info['gerneral_broker_website']) != '') {
                                                            echo '<a href="' . $info['gerneral_broker_website'] . '" target="_blank">' . $info['gerneral_broker_website'] . '</a>';
                                                        } else {
                                                            echo $empty_answer;
                                                        }
                                                        ?>
													</p>
													  <p class="rb_company_input_data">
														<span class="rb_company_input_head admin_edit_field"> Related Brands: </span><?php
                                                        if (isset($brand_info) && ($brand_info) != '') {
																foreach($brand_info as $brand_name){
																echo '<span class="indus_cat_info">'.$brand_name.'</span>';
															}
                                                        } else {
                                                            echo $empty_answer;
                                                        }
                                                        ?>
													</p>

                                                </div>

                                                <div class="col-sm-12 col-md-12">
                                                    <p class="text-right rb_edit_button">
														<?php
														$edit_base['current_step']=3;
														$company_edit=getCompanyEditlink($company_edit_url,$edit_base);
														?>														
                                                        <a class="btn btn-info btn-sm" href="<?php echo $company_edit; ?>" role="button">Edit</a>
                                                    </p>
                                                </div>
                                                <div class="col-sm-12 col-md-12">
                                                    <p class="rb_company_heading">Territory Checks</p>
                                                    <p class="rb_company_input_data text_cap">
														<span class="rb_company_input_head"> Name:</span>
														<?php
															if (isset($info['territory_person_fullname']) && ($info['territory_person_fullname']) != '' && $info['territory_person'] == 1) {
																echo $info['territory_person_fullname'];
															} else {
																echo $empty_answer;
															}
														?>
													</p>

                                                    <p class="rb_company_input_data">
														<span class="rb_company_input_head"> Office:  </span><?php
                                                        if (isset($info['territory_person_phonenumber']) && ($info['territory_person_phonenumber']) != '' && $info['territory_person'] == 1) {
                                                            echo $info['territory_person_phonenumber'];
															if (isset($info['territory_person_phonenumber_ext']) && ($info['territory_person_phonenumber_ext']) != '') {
																echo ' x'.$info['territory_person_phonenumber_ext'];
															}															
                                                        } else {
                                                            echo $empty_answer;
                                                        }
                                                        ?>
													</p>
													
                                                    <p class="rb_company_input_data">
														<span class="rb_company_input_head">Email:</span><?php
														if (isset($info['territory_person_email']) && ($info['territory_person_email']) != '' && $info['territory_person'] == 1) {
                                                            echo '<a href="mailto:' . $info['territory_person_email'] . '?Subject=Contact%20Us" target="_blank">' . $info['territory_person_email'] . '</a>';
                                                        }														
                                                        elseif (isset($info['territory_email']) && ($info['territory_email']) != '' && $info['territory_person'] == 2) {
                                                            echo '<a href="mailto:' . $info['territory_email'] . '?Subject=Contact%20Us" target="_blank">' . $info['territory_email'] . '</a>';
                                                        } else {
                                                            echo $empty_answer;
                                                        }
                                                        ?>
													</p>													

                                                    <p class="rb_company_input_data"> <b>If No Territory Check Contact Listed, Email Sales Contact</b></p>
                                                </div>
                                                <div class="col-sm-12 col-md-12">
                                                    <p class="rb_company_heading">Referrals</p>
                                                    <p class="rb_company_input_data"> <span class="rb_company_input_head">Preferred Email Address:</span>
                                                        <?php
                                                        if (isset($info['territory_person_referrals_email']) && ($info['territory_person_referrals_email']) != '' && $info['territory_person_referrals'] == 1) {
                                                            echo '<a href="mailto:' . $info['territory_person_referrals_email'] . '?Subject=Contact%20Us" target="_blank">' . $info['territory_person_referrals_email'] . '</a>';
                                                        } else {
                                                            echo $empty_answer;
                                                        }
                                                        ?>
													</p>
                                                    <p class="rb_company_input_data"><b>If No Preferred Referral Of Lead Email Address Listed, Email Sales Contact</b></p>
                                                </div>

                                                <div class="col-md-12">
                                                    <p class="text-right rb_edit_button">
														<?php
														$edit_base['current_step']=2;
														$company_edit=getCompanyEditlink($company_edit_url,$edit_base);
														?>		
														
														<a class="btn btn-primary btn-sm" href="<?php echo get_option($shortname . "_company_user_management",home_url()); ?>" role="button" target="_blank">Add/Edit Logins</a>
                                                        <a class="btn btn-info btn-sm" href="<?php echo $company_edit; ?>" role="button">Edit</a>
                                                    </p>
                                                </div>											
                                                <div class="col-sm-12 col-md-12">
                                                    <p class="rb_company_heading">Manager of Sales/Development</p>
														<div class="row">
															<div class="col-sm-8 col-md-8">
																<p class="rb_company_input_data  text_cap">
																	<span class="rb_company_input_head"> Name:  </span>
																	<?php
																	if (isset($info['sales_firstname']) && ($info['sales_firstname']) != '') {
																		echo $info['sales_firstname'];
																	}
																	if (isset($info['sales_nickname']) && ($info['sales_nickname']) != '') {
																		echo ' (' . $info['sales_nickname'] . ')';
																	}
																	if (isset($info['sales_lastname']) && ($info['sales_lastname']) != '') {
																		echo ' ' . $info['sales_lastname'];
																	}
																	if ((!isset($info['sales_firstname']) && ($info['sales_firstname']) == '') && (!isset($info['sales_nickname']) && ($info['sales_nickname']) == '') && (!isset($info['sales_lastname']) && ($info['sales_lastname']) == '')) {
																		echo $empty_answer;
																	}
																	?>
																</p>
																
																<?php if (isset($info['sales_title']) && ($info['sales_title']) != '') { ?>
																	<p class="rb_company_input_data text_cap">
																		<span class="rb_company_input_head"> Title:  </span><?php echo $info['sales_title']; ?>																	
																	</p>
																<?php } ?>

																<p class="rb_company_input_data"><span class="rb_company_input_head"> Office:  </span><?php
																	if (isset($info['sales_off_phone']) && ($info['sales_off_phone']) != '') {
																		echo $info['sales_off_phone'];
																		if (isset($info['sales_off_phone_ext']) && ($info['sales_off_phone_ext']) != '') {
																			echo ' x'.$info['sales_off_phone_ext'];
																		}
																		if (isset($info['sales_timezone']) && ($info['sales_timezone']) != '') {
																			echo '<span class="pull-right">'.getexplodeData($info['sales_timezone'], 'timezone_location', 'timezones', 'id').'</span>';
																		}																			
																	} else {
																		echo $empty_answer;
																	}
																	?>
																</p>
																
																<?php if (isset($info['sales_cell_number']) && ($info['sales_cell_number']) != '') { ?>
																	<p class="rb_company_input_data">
																		<span class="rb_company_input_head"> Cell:  </span><?php echo $info['sales_cell_number']; ?> 																
																	</p>
																<?php }?>
																
															</div>
															<div class="col-sm-4 col-md-4">
																<?php if (isset($info['sales_team_photo']) && ($info['sales_team_photo']) != '') { 
																echo '<p class="rb_company_input_data">';
																?>
																	<img class="img-thumbnail img-responsive" src="<?php echo aq_resize(wp_get_attachment_url($info['sales_team_photo']), $sales_contact_thumb_width); ?>">	
																<?php
																echo ' </p>';
																} ?>														
															</div>
															<div class="col-sm-12 col-md-12">
																<p class="rb_company_input_data"><span class="rb_company_input_head"> Email:  </span><?php
																	if (isset($info['sales_email']) && ($info['sales_email']) != '') {
																		echo '<a href="mailto:' . $info['sales_email'] . '?Subject=Contact%20Us" target="_blank">' . $info['sales_email'] . '</a>';
																	} else {
																		echo $empty_answer;
																	}
																	?>
																</p>															
															</div>
														</div>
                                                </div>
												<div class="col-sm-12 col-md-12">
                                                    <p class="rb_company_heading">Sales Contact(s)</p>
													<div class="row">
														<div class="col-sm-8 col-md-8">
															<?php
															if (isset($info['sales_teammember_title']) && ($info['sales_teammember_title']) != '') {
																$count = count($info['sales_teammember_title']);
																$new_count = 0;
																//print_r($info['sales_teammember_title']);
																for ($i = 0; $i <= $new_count; $i++) {
																	?>
																	<p class="rb_company_input_data text_cap"><span class="rb_company_input_head"> Name:  </span><?php
																		if (isset($info['sales_teammember_firstname'][$i]) && ($info['sales_teammember_firstname'][$i]) != '') {
																			echo $info['sales_teammember_firstname'][$i];
																		}
																		?><?php
																		if (isset($info['sales_teammember_nickname'][$i]) && ($info['sales_teammember_nickname'][$i]) != '') {
																			echo ' (' . $info['sales_teammember_nickname'][$i] . ')';
																		}
																		?> <?php
																		if (isset($info['sales_teammember_lastname'][$i]) && ($info['sales_teammember_lastname'][$i]) != '') {
																			echo ' ' . $info['sales_teammember_lastname'][$i];
																		}
																		?>
																	</p>
																	
																	<?php if (isset($info['sales_teammember_title'][$i]) && ($info['sales_teammember_title'][$i]) != '') { ?>
																		<p class="rb_company_input_data text_cap">
																			<span class="rb_company_input_head"> Title:  </span><?php echo $info['sales_teammember_title'][$i]; ?>
																		</p>
																	<?php } ?>
																		
																	<p class="rb_company_input_data">
																		<span class="rb_company_input_head"> Office:  </span><?php
																		if (isset($info['sales_teammember_off_phone'][$i]) && ($info['sales_teammember_off_phone'][$i]) != '') {
																			echo $info['sales_teammember_off_phone'][$i];
																			if (isset($info['sales_teammember_off_phone_ext'][$i]) && ($info['sales_teammember_off_phone_ext'][$i]) != '') {
																				echo ' x'.$info['sales_teammember_off_phone_ext'][$i];
																			}																	
																		}
																		if (isset($info['sales_teammember_timezone'][$i]) && ($info['sales_teammember_timezone'][$i]) != '') {
																			echo '<span class="pull-right">'.getexplodeData($info['sales_teammember_timezone'][$i], 'timezone_location', 'timezones', 'id').'</span>';
																		}																		
																		?>
																	</p>
																	
																	<?php if (isset($info['sales_teammember_cell_number'][$i]) && ($info['sales_teammember_cell_number'][$i]) != '') { ?>
																		<p class="rb_company_input_data">
																			<span class="rb_company_input_head"> Cell:  </span><?php echo $info['sales_teammember_cell_number'][$i];	?>																			
																		</p>
																	<?php } ?>																	
																																												
																<?php }
															} else {
																echo $empty_answer;
															}
															?>																									
														</div>
														<div class="col-sm-4 col-md-4">
															<?php
															if (isset($info['sales_teammember_title']) && ($info['sales_teammember_title']) != '') {
																$count = count($info['sales_teammember_title']);
																$new_count = 0;
																//print_r($info['sales_teammember_title']);
																for ($i = 0; $i <= $new_count; $i++) {	
																?>
																	<?php if (isset($info['sales_teammember_email_photo_' . $i]) && ($info['sales_teammember_email_photo_' . $i]) != '') { 
																		echo '<p class="rb_company_input_data">';
																			$salesimage_attributes = wp_get_attachment_image_src( $info['sales_teammember_email_photo_' . $i], 'full' );
																			if(is_array($salesimage_attributes) && $salesimage_attributes[1] < $sales_contact_thumb_width){ ?>																
																				<img class="img-thumbnail img-responsive full-image" src="<?php echo wp_get_attachment_url($info['sales_teammember_email_photo_' . $i]); ?>">																	
																			<?php }else{ ?>
																				<img class="img-thumbnail img-responsive" src="<?php echo aq_resize(wp_get_attachment_url($info['sales_teammember_email_photo_' . $i]), $sales_contact_thumb_width); ?>">																	
																		<?php } 
																		echo '</p>';
																		}
																	?>		
																<?php } ?>
																<?php
															} else {
																echo $empty_answer;
															}
															?>															
														</div>
														<div class="col-sm-12 col-md-12">
															<?php
															if (isset($info['sales_teammember_title']) && ($info['sales_teammember_title']) != '') {
																$count = count($info['sales_teammember_title']);
																$new_count = 0;
																//print_r($info['sales_teammember_title']);
																for ($i = 0; $i <= $new_count; $i++) { ?>														
																	<p class="rb_company_input_data">
																		<span class="rb_company_input_head"> Email:  </span><?php
																		if (isset($info['sales_teammember_email'][$i]) && ($info['sales_teammember_email'][$i]) != '') {
																			echo '<a href="mailto:' . $info['sales_teammember_email'][$i] . '?Subject=Contact%20Us" target="_blank">' . $info['sales_teammember_email'][$i] . '</a>';
																		}
																		?>
																	</p>
															<?php
																}
																if ($count > 1) {
																	echo '<a href="' . $sales_member_page . '" target="_blank"> See More Sales Contacts...</a>';
																}															}
															?>																
														</div>
													</div>

												</div>
                                                <div class="col-sm-12 col-md-12">
                                                    <p class="text-right rb_edit_button">
														<?php
														$edit_base['current_step']=4;
														$company_edit=getCompanyEditlink($company_edit_url,$edit_base);
														?>														
                                                        <a class="btn btn-info btn-sm" href="<?php echo $company_edit; ?>" role="button">Edit</a>
                                                    </p>
                                                </div>
                                                <div class="col-sm-12 col-md-12">
                                                    <p class="rb_company_heading">Referral Fees</p>
                                                    <p class="rb_company_input_data">  
														<span class="rb_company_input_head"> Single:  </span>
														<?php
                                                        if (isset($info['referral_feesingleunit']) && ($info['referral_feesingleunit']) != '') {
                                                            echo '$ <span class="rb_number">' . $info['referral_feesingleunit'] . '</span>';															                                                        
														}else{
															 echo $empty_answer;
														}
                                                        if (isset($info['referral_feecalculationtype']) && $info['referral_feecalculationtype'] == 1) {
                                                            echo '<span> Estimate Only - See Calculation Below</span>';															                                                        
														}														
                                                        ?>
													</p>
													
                                                    <p class="rb_company_input_data">
														<span class="rb_company_input_head">Fee Calculation Method:  </span>
														<?php
															if (isset($info['referral_feecalculationdetails']) && ($info['referral_feecalculationdetails']) != '') {
																echo $info['referral_feecalculationdetails'];
															}else{
																echo $empty_answer;
															}
                                                        ?>
													</p>													

                                                    <p class="rb_company_input_data">
														<span class="rb_company_input_head">Multi:  </span>
														<?php
                                                        if (isset($info['referral_feemultiunits']) && ($info['referral_feemultiunits']) != '') {
                                                            echo $info['referral_feemultiunits'];
                                                        } else {
                                                            echo $empty_answer;
                                                        }
                                                        ?>
													</p>
                                                    <p class="rb_company_input_data">
														<span class="rb_company_input_head">Area/Master:  </span>
														<?php
                                                        if (isset($info['referral_areadevdetails']) && ($info['referral_areadevdetails']) != '' && $info['referral_areadevtype'] == 1) {
                                                            echo $info['referral_areadevdetails'];
                                                        } else {
                                                            echo $empty_answer;
                                                        }
                                                        ?>
													</p>
                                                    <p class="rb_company_input_data">
														<span class="rb_company_input_head">Resales:  </span>
														<?php
                                                        if (isset($info['referral_feeresaledetails']) && ($info['referral_feeresaledetails']) != '' && $info['referral_feerelsaleetype'] == 1) {
                                                            echo $info['referral_feeresaledetails'];
                                                        } else {
                                                            echo $empty_answer;
                                                        }
                                                        ?>
													</p>
													<p class="rb_company_input_data"> 
														<span class="rb_company_input_head">Current Promo: </span>
														<?php
															if (isset($info['referral_promotiontype']) && ($info['referral_promotiontype']) != '' && $info['referral_promotiontype']==1) {
																echo getTypeText($info['referral_promotiontype']);
																 for ($i = 1; $i <= 5; $i++) {
																	 if (isset($info['uploads_company_promo_file_'.$i]) && ($info['uploads_company_promo_file_'.$i]) != '' ){
																	 ?>
																		 <a target="_BLANK" href="<?php echo wp_get_attachment_url(($info['uploads_company_promo_file_'.$i])); ?>" class=""><span>View File</span></a>
																		 <?php
																	 }
																 }														
															} else {
																echo $empty_answer;
															}
														?>
													</p>
													
													<p class="rb_company_input_data">   <span class="rb_company_input_head"> Promo Period: </span><?php
														if (isset($info['referral_promotiontype']) && ($info['referral_promotiontype']) != '' && $info['referral_promotiontype']==1) {													
															if (isset($info['referral_promotionstartdate']) && ($info['referral_promotionstartdate']) != '') {
																echo $info['referral_promotionstartdate'];
															}
															if (isset($info['referral_promotionenddate']) && ($info['referral_promotionenddate']) != '') {
																echo ' - ' . $info['referral_promotionenddate'];
															}
														}else{
															echo $empty_answer;
														}
														?>
													</p>													
													
                                                </div>

                                            
                                                <div class="col-sm-12 col-md-12">
                                                    <p class="text-right rb_edit_button">
														<?php
														$edit_base['current_step']=8;
														$company_edit=getCompanyEditlink($company_edit_url,$edit_base);
														?>													
                                                        <a class="btn btn-info btn-sm" href="<?php echo $company_edit; ?>" role="button">Edit</a>
                                                    </p>
                                                </div>
                                                <div class="col-sm-12 col-md-12">
                                                    <p class="rb_company_heading">Agreement Information</p>												
                                                    <p class="rb_company_input_data">
														<span class="rb_company_input_head"> Entity Type:</span><?php
                                                        if (isset($info['legal_entityType']) && ($info['legal_entityType']) != '') {
                                                            echo $info['legal_entityType'];
                                                        } else {
                                                            echo $empty_answer;
                                                        }
                                                        ?>
													</p>
                                                    <p class="rb_company_input_data">
														<span class="rb_company_input_head">Where Organized:</span><?php
                                                        if (isset($info['legal_companyOrganized']) && ($info['legal_companyOrganized']) != '') {
                                                            echo $categories = getexplodeData($info['legal_companyOrganized'], 'name', 'location', 'location_id');
                                                        } else {
                                                            echo $empty_answer;
                                                        }
                                                        ?>
													</p>
													<p class="rb_company_input_data">
														<?php 
														$fileexibhit = get_user_meta($fr_user_id, 'pie_upload_23', true);
														$dateexibhit = get_user_meta($fr_user_id, 'pie_date_24', true);
														?>
														<span class="rb_company_input_head">Tech Fee Exhibit B File:</span><?php
                                                        if (isset($fileexibhit) && ($fileexibhit) != '') {
                                                            echo '<a href="'.$fileexibhit.'">View File</a>';
                                                        } else {
                                                            echo $empty_answer;
                                                        }
                                                        ?>
													</p>
													<p class="rb_company_input_data">
														<span class="rb_company_input_head">Tech Fee Date:</span><?php
                                                        if (isset($dateexibhit) && ($dateexibhit) != '') {
                                                            echo getDateFromArray($dateexibhit);
                                                        } else {
                                                            echo $empty_answer;
                                                        }
                                                        ?>
													</p>
													
                                                </div>
																								
                                                <div class="col-sm-12 col-md-12">
                                                    <p class="rb_company_input_data">
														<span class="rb_company_input_head admin_edit_field">Agreement Signed Date:</span><?php
                                                        if (isset($info['pie_date_5']) && ($info['pie_date_5']) != '') {
														   echo getDateFromArray($info['pie_date_5']);
                                                        } else {
                                                            echo $empty_answer;
                                                        }
                                                        ?>
													</p>
                                                    <p class="rb_company_input_data">
														<span class="rb_company_input_head admin_edit_field">Agreement:</span>
														<?php if (isset($info['pie_upload_3']) && ($info['pie_upload_3']) != '') { ?>
                                                            <a target="_BLANK" href="<?php echo $info['pie_upload_3']; ?>" class=""><span>View File</span></a>
															<?php if (isset($info['pie_dropdown_12']) && ($info['pie_dropdown_12']) != '') {echo $info['pie_dropdown_12']; }?>														
                                                        <?php } else {
                                                            echo $empty_answer;
                                                        }
                                                        ?>
													</p>
                                                    <p class="rb_company_input_data">
														<span class="rb_company_input_head admin_edit_field">Amendment:</span><?php if (isset($info['pie_upload_6']) && ($info['pie_upload_6']) != '') { ?>
                                                            <a target="_BLANK" href="<?php echo $info['pie_upload_6']; ?>" class=""><span>View File</span></a>
                                                        <?php } else {
                                                            echo $empty_answer;
                                                        }
                                                        ?>
													</p>
                                                    <p class="rb_company_input_data">
														<span class="rb_company_input_head admin_edit_field">Agreement End Date:</span>
                                                        <?php
                                                        if (isset($info['pie_date_7']) && ($info['pie_date_7']) != '') {
                                                            echo getDateFromArray($info['pie_date_7']);
                                                        } else {
                                                            echo $empty_answer;
                                                        }
                                                        ?>
													</p>
                                                    <p class="rb_company_input_data">
														<span class="rb_company_input_head admin_edit_field">Company Information Completed:</span>
                                                        <?php
                                                        if (isset($info['pie_date_4']) && ($info['pie_date_4']) != '') {
                                                            echo getDateFromArray($info['pie_date_4']);
                                                        } else {
                                                            echo $empty_answer;
                                                        }
                                                        ?>
													</p>
                                                </div>
												
                                                <div class="col-sm-12 col-md-12">
                                                    <p class="rb_company_heading">Signor of Agreement</p>
                                                    <p class="rb_company_input_data text_cap">
														<span class="rb_company_input_head"> Name: </span><?php
                                                        if (isset($info['legal_signFBCFirstName']) && ($info['legal_signFBCFirstName']) != '') {
                                                            echo $info['legal_signFBCFirstName'];
                                                        }
                                                        if (isset($info['legal_signFBCLastName']) && ($info['legal_signFBCLastName']) != '') {
                                                            echo ' ' . $info['legal_signFBCLastName'];
                                                        }
                                                        if ((!isset($info['legal_signFBCFirstName']) && ($info['legal_signFBCFirstName']) == '') && (!isset($info['legal_signFBCLastName']) && ($info['legal_signFBCLastName']) == '')) {
                                                            echo $empty_answer;
                                                        }
                                                        ?>
													</p>
													
													<?php if (isset($info['legal_signFBCTitle']) && ($info['legal_signFBCTitle']) != '') { ?>
														<p class="rb_company_input_data text_cap">
															<span class="rb_company_input_head"> Title: </span><?php echo $info['legal_signFBCTitle']; ?>
														</p>
													<?php } ?>
													
                                                    <p class="rb_company_input_data"><span class="rb_company_input_head">Office:</span><?php
                                                        if (isset($info['legal_signFBCPhone']) && ($info['legal_signFBCPhone']) != '') {
                                                            echo $info['legal_signFBCPhone'];
															if (isset($info['legal_signFBCPhone_ext']) && ($info['legal_signFBCPhone_ext']) != '') {
																echo ' x'.$info['legal_signFBCPhone_ext'];
															}
                                                        } else {
                                                            echo $empty_answer;
                                                        }
                                                        ?>
													</p>
													
                                                    <p class="rb_company_input_data"><span class="rb_company_input_head">Email:</span><?php
                                                        if (isset($info['legal_signFBCEmail']) && ($info['legal_signFBCEmail']) != '') {
                                                            echo '<a href="mailto:' . $info['legal_signFBCEmail'] . '?Subject=Contact%20Us" target="_blank">' . $info['legal_signFBCEmail'] . '</a>';
                                                        } else {
                                                            echo $empty_answer;
                                                        }
                                                        ?>
													</p>
                                                </div>
												
                                                <div class="col-sm-12 col-md-12">
													<p class="rb_company_heading">Agreement Review</p>	
                                                    <p class="rb_company_input_data text_cap"> 
														<span class="rb_company_input_head">Reviewer Name: </span><?php
                                                        if (isset($info['legal_FBCReferralReviewerFirstname']) && ($info['legal_FBCReferralReviewerFirstname']) != '' && $info['legal_FBCReferralReviewType'] == 1) {
                                                            echo $info['legal_FBCReferralReviewerFirstname'];
                                                        }
                                                        if (isset($info['legal_FBCReferralReviewerLastname']) && ($info['legal_FBCReferralReviewerLastname']) != '' && $info['legal_FBCReferralReviewType'] == 1) {
                                                            echo ' '.$info['legal_FBCReferralReviewerLastname'];
                                                        }else{
															echo $empty_answer;
														}
                                                        ?> 
													</p>
                                                    <p class="rb_company_input_data text_cap">
														<span class="rb_company_input_head">Title:  </span>
														<?php
                                                        if (isset($info['legal_FBCReferralSenttoTitle']) && ($info['legal_FBCReferralSenttoTitle']) != '' && $info['legal_FBCReferralReviewType'] == 1) {
                                                            echo $info['legal_FBCReferralSenttoTitle'];
                                                        } else {
                                                            echo $empty_answer;
                                                        }
                                                        ?>
													</p>
													
                                                    <p class="rb_company_input_data">
														<span class="rb_company_input_head">Office: </span>
														<?php
                                                        if (isset($info['legal_FBCReferralSenttoPhone']) && ($info['legal_FBCReferralSenttoPhone']) != '' && $info['legal_FBCReferralReviewType'] == 1) {
                                                            echo $info['legal_FBCReferralSenttoPhone'];
															if (isset($info['legal_FBCReferralSenttoPhone_ext']) && ($info['legal_FBCReferralSenttoPhone_ext']) != '') {
																echo ' x'.$info['legal_FBCReferralSenttoPhone_ext'];
															}						
                                                        } else {
                                                            echo $empty_answer;
                                                        }
                                                        ?>
													</p>
													
                                                    <p class="rb_company_input_data">
														<span class="rb_company_input_head">Email:  </span>
														<?php
                                                        if (isset($info['legal_FBCReferralSenttoEmail']) && ($info['legal_FBCReferralSenttoEmail']) != '' && $info['legal_FBCReferralReviewType'] == 1) {
                                                            echo '<a href="mailto:' . $info['legal_FBCReferralSenttoEmail'] . '?Subject=Contact%20Us" target="_blank">' . $info['legal_FBCReferralSenttoEmail'] . '</a>';
                                                        } else {
                                                            echo $empty_answer;
                                                        }
                                                        ?>
													</p>
                                                </div>
                                                <div class="col-sm-12 col-md-12">
                                                    <p class="rb_company_heading">Send Invoices to  </p>
                                                    <p class="rb_company_input_data text_cap">
														<span class="rb_company_input_head">Name:  </span><?php
                                                        if (isset($info['legal_FBCReferralSenttoFirstname']) && ($info['legal_FBCReferralSenttoFirstname']) != '') {
                                                            echo $info['legal_FBCReferralSenttoFirstname'];
                                                        }
                                                        ?> <?php
                                                        if (isset($info['legal_FBCReferralSenttoLastname']) && ($info['legal_FBCReferralSenttoLastname']) != '') {
                                                            echo $info['legal_FBCReferralSenttoLastname'];
                                                        }
                                                        if ((!isset($info['legal_FBCReferralSenttoFirstname']) && ($info['legal_FBCReferralSenttoFirstname']) == '') && (!isset($info['legal_FBCReferralSenttoLastname']) && ($info['legal_FBCReferralSenttoLastname']) == '')) {
                                                            echo $empty_answer;
                                                        }
                                                        ?>
													</p>
													<?php if (isset($info['legal_FBCReferralSenttoTitle']) && ($info['legal_FBCReferralSenttoTitle']) != '') { ?>
														<p class="rb_company_input_data text_cap">
															<span class="rb_company_input_head">Title:  </span><?php echo $info['legal_FBCReferralSenttoTitle'];?>
														</p>
													<?php } ?>

                                                    <p class="rb_company_input_data"><span class="rb_company_input_head">Office: </span><?php
                                                        if (isset($info['legal_FBCReferralSenttoPhone']) && ($info['legal_FBCReferralSenttoPhone']) != '') {
                                                            echo $info['legal_FBCReferralSenttoPhone'];
															if (isset($info['legal_FBCReferralSenttoPhone_ext']) && ($info['legal_FBCReferralSenttoPhone_ext']) != '') {
																echo ' x'.$info['legal_FBCReferralSenttoPhone_ext'];
															}
                                                        } else {
                                                            echo $empty_answer;
                                                        }
                                                        ?>
													</p>
													
                                                    <p class="rb_company_input_data"><span class="rb_company_input_head">Email:  </span><?php
                                                        if (isset($info['legal_FBCReferralSenttoEmail']) && ($info['legal_FBCReferralSenttoEmail']) != '') {
                                                            echo '<a href="mailto:' . $info['legal_FBCReferralSenttoEmail'] . '?Subject=Contact%20Us" target="_blank">' . $info['legal_FBCReferralSenttoEmail'] . '</a>';
                                                        } else {
                                                            echo $empty_answer;
                                                        }
                                                        ?>
													</p>													
                                                    <p class="rb_company_input_data"><a href="http://www.irs.ustreas.gov/pub/irs-pdf/fw9.pdf" target="_blank">W-9 form at IRS for Broker to Complete/Submit</a></p>
                                                </div>
                                                <div class="col-md-12 col-sm-12">
                                                    <p class="rb_company_heading">*FBC Liaison</p>
                                                    <p class="rb_company_input_data text_cap"> 
														<span class="rb_company_input_head">Contact: </span>
														<?php
															if(isset($broker_info['broker_affilate_firstname']) && !empty($broker_info['broker_affilate_firstname'])){echo $broker_info['broker_affilate_firstname'];}
															if(isset($broker_info['broker_affilate_lastname']) && !empty($broker_info['broker_affilate_lastname'])){echo ' '.$broker_info['broker_affilate_lastname'];}
															if(empty($broker_info['broker_affilate_firstname']) || empty($broker_info['broker_affilate_lastname'])){echo $empty_answer; }												
														?>
													</p>
                                                    <p class="rb_company_input_data">
														<span class="rb_company_input_head">Company:</span>
														<?php
															if(isset($broker_info['broker_company_name']) && !empty($broker_info['broker_company_name'])){
																echo $broker_info['broker_company_name'];
															}else{
																echo $empty_answer;
															}
														?>
													</p>
                                                    <p class="rb_company_input_data">
														<span class="rb_company_input_head">Office:  </span>
														<?php
															if(isset($broker_info['broker_phone_number']) && !empty($broker_info['broker_phone_number'])){
																echo $broker_info['broker_phone_number'];
																if(isset($broker_info['broker_phone_number_ext']) && !empty($broker_info['broker_phone_number_ext'])){
																	echo ' x'.$broker_info['broker_phone_number_ext'];
																}																
															}else{
																echo $empty_answer;
															}
														?>
													</p>
													
													<?php if(isset($broker_info['broker_cell_number']) && !empty($broker_info['broker_cell_number'])){ ?>
														<p class="rb_company_input_data">
															<span class="rb_company_input_head">Cell:  </span><?php echo $broker_info['broker_cell_number']; ?>														
														</p>
													<?php } ?>
													
                                                    <p class="rb_company_input_data">
														<span class="rb_company_input_head">Email: </span>
														<?php
															if(isset($broker_info['broker_email_address']) && !empty($broker_info['broker_email_address'])){
																echo '<a href="mailto:' . $broker_info['broker_email_address'] . '?Subject=Contact%20Us" target="_blank">'.$broker_info['broker_email_address'].'</a>';
															}else{
																echo $empty_answer;
															}
														?>
													</p>													
                                                </div>
                                            </div>
                                  
                                    </div >
                                        <div class="col-sm-7 col-md-8 rb_landingright_row rb_landingright_row_height">
                                            <div class="col-sm-12 col-md-12">
                                                <p class="text-right rb_edit_button">
													<?php
													$edit_base['current_step']=5;
													$company_edit=getCompanyEditlink($company_edit_url,$edit_base);
													?>												
                                                    <a class="btn btn-info btn-sm" href="<?php echo $company_edit; ?>" role="button">Edit</a>
                                                </p>

                                                <p class="rb_company_input_data">
													<span class="rb_company_input_head">Industry Category:</span>												
													<?php 
													$industrycats=getIndustryCatNames($info['brand_industrycat'],$info['brand_industrysubcat']);
													if(is_array($industrycats) && count($industrycats)>0){ 
														foreach($industrycats as $industrycat){
													?>
													<span class="indus_cat_info"><?php echo $industrycat['cat_name'];?>: <?php if(is_array($industrycat['sub_cat_name']) && count($industrycat['sub_cat_name'])>0){echo implode(', ',$industrycat['sub_cat_name']);}else{echo 'Other';}?></span>
													<?php
														}//end foreach
													}else{
														echo $empty_answer;
													}
													?>
                                                </p>

                                                <p class="rb_company_input_data">   <span class="rb_company_input_head">Company Offers:</span><?php
                                                    if (isset($info['brand_franchise']) && ($info['brand_franchise']) != '') {
                                                        echo $info['brand_franchise'];
                                                    } else {
                                                        echo $empty_answer;
                                                    }
                                                    ?>
												</p>
												
                                            </div>
                                            <div class="col-sm-12 col-md-12">
                                                <p class="text-right rb_edit_button">
													<?php
													$edit_base['current_step']=6;
													$company_edit=getCompanyEditlink($company_edit_url,$edit_base);
													?>													
                                                    <a class="btn btn-info btn-sm" href="<?php echo $company_edit; ?>" role="button">Edit</a>
                                                </p>
												
                                                <p class="rb_company_heading">FINANCIAL</p>
                                                <p class="rb_company_input_data"><span class="rb_company_input_head">Net Worth Minimum:  </span><?php
                                                    if (isset($info['financial_minimumNetWorthRequirement']) && ($info['financial_minimumNetWorthRequirement']) != '') {
                                                        echo '$ <span class="rb_number">' . $info['financial_minimumNetWorthRequirement'] . '</span>';
                                                    } else {
                                                        echo $empty_answer;
                                                    }
                                                    ?></p>
                                                <p class="rb_company_input_data">
													<span class="rb_company_input_head"> Liquidity:  </span><?php
                                                    if (isset($info['financial_liquidityrequirement']) && ($info['financial_liquidityrequirement']) != '') {
                                                        echo '$ <span class="rb_number">' . $info['financial_liquidityrequirement'] . '</span>';
                                                    } else {
                                                        echo $empty_answer;
                                                    }
                                                    ?>
												</p>
												
												<p class="rb_company_input_data"><span class="rb_company_input_head">Disclosure/FDD Current Effective Date:</span><?php
													if (isset($info['salesprocess_dateDisclosureDocument']) && ($info['salesprocess_dateDisclosureDocument']) != '') {
														echo $info['salesprocess_dateDisclosureDocument'];
													} else {
														echo $empty_answer;
													}
													?>
												</p>

												<p class="rb_company_input_data">
													<span class="rb_company_input_head">Disclosure Document:</span>
													<?php if (isset($info['uploads_disclosureDocument']) && ($info['uploads_disclosureDocument']) != '') {
														?>
														<a target="_BLANK" href="<?php echo wp_get_attachment_url($info['uploads_disclosureDocument']); ?>" class=""><span>View File</span></a>
													<?php } else {
														echo $empty_answer;
													} ?>
												</p>

												<p class="rb_company_input_data">
													<span class="rb_company_input_head">Financial Representation/Item 19:</span>
													<?php 
													if (isset($info['salesprocess_disclosureDocumentType']) && ($info['salesprocess_disclosureDocumentType']) == 1) { ?>
														<span>Yes </span>
													<?php } else {
														echo 'No';
													}													
													if (isset($info['salesprocess_financialRepresentationDoc']) && ($info['salesprocess_financialRepresentationDoc']) != '') { ?>
														<a target="_BLANK" href="<?php echo wp_get_attachment_url($info['salesprocess_financialRepresentationDoc']); ?>" class=""><span>View File</span></a>
													<?php }?>
												</p>												

                                                <p class="rb_company_input_data">
													<span class="rb_company_input_head">Investment range:</span><?php
                                                    if (isset($info['financial_investmentlowend']) && ($info['financial_investmentlowend']) != '') {
                                                        echo "$ <span class='rb_number'>" . $info['financial_investmentlowend'] . "</span>";
                                                    }
                                                    if (isset($info['financial_investmenthighend']) && ($info['financial_investmenthighend']) != '') {
                                                        echo ' - $ <span class="rb_number">' . $info['financial_investmenthighend'] . '</span>';
                                                    }
                                                    ?></p>
                                                <p class="rb_company_input_data">
													<span class="rb_company_input_head">Average Investment:  </span><?php
                                                    if (isset($info['financial_anticipatedinvestment']) && ($info['financial_anticipatedinvestment']) != '') {
                                                        echo '$ <span class="rb_number">' . $info['financial_anticipatedinvestment'] . '</span>';
                                                    } else {
                                                        echo $empty_answer;
                                                    }
                                                    ?>
												</p>
                                                <p class="rb_company_input_data">
												<span class="rb_company_input_head"> Franchise Fee, Single: </span><?php
                                                    if (isset($info['financial_franchisefeesingle']) && ($info['financial_franchisefeesingle']) != '') {
                                                        echo '$ <span class="rb_number">' . $info['financial_franchisefeesingle'] . '</span>';
                                                    } else {
                                                        echo $empty_answer;
                                                    }
                                                    ?>
												</p>
												
                                                <p class="rb_company_input_data">
												<span class="rb_company_input_head"> Franchise Fee, multiple units: </span><?php
                                                    if (isset($info['financial_franchisefeemultiple']) && ($info['financial_franchisefeemultiple']) != '') {
                                                        echo '$ <span class="rb_number">' . $info['financial_franchisefeemultiple'] . '</span>';
                                                    } else {
                                                        echo $empty_answer;
                                                    }
                                                    ?>
												</p>												

                                                <p class="rb_company_input_data">
													<span class="rb_company_input_head"> Fee Calculation Method, if Applicable: </span><?php
                                                    if (isset($info['financial_territoryfeecalculation']) && ($info['financial_territoryfeecalculation']) != '') {
                                                        echo $info['financial_territoryfeecalculation'];
                                                    } else {
                                                        echo $empty_answer;
                                                    }
                                                    ?>
												</p>
                                                <p class="rb_company_input_data">
													<span class="rb_company_input_head"> Royalty: </span><?php
                                                    if (isset($info['financial_royalty']) && ($info['financial_royalty']) != '') {
                                                        echo $info['financial_royalty'];
                                                    } else {
                                                        echo $empty_answer;
                                                    }
                                                    ?>
												</p>
                                                <p class="rb_company_input_data">
													<span class="rb_company_input_head"> Ad: </span><?php
                                                    if (isset($info['financial_advertisingfee']) && ($info['financial_advertisingfee']) != '') {
                                                        echo $info['financial_advertisingfee'];
                                                    } else {
                                                        echo $empty_answer;
                                                    }
                                                    ?>
												</p>
                                                <p class="rb_company_input_data">
													<span class="rb_company_input_head"> Other major fees, including technology:   </span><?php
                                                    if (isset($info['financial_significantfees']) && ($info['financial_significantfees']) != '') {
                                                        echo $info['financial_significantfees'];
                                                    } else {
                                                        echo $empty_answer;
                                                    }
                                                    ?>
												</p>												
                                                <p class="rb_company_input_data">
													<span class="rb_company_input_head">Multi/Area Dev US:  </span><?php
                                                    if (isset($info['referral_areadevtype']) && ($info['referral_areadevtype']) != '') {
                                                        echo getTypeText($info['referral_areadevtype']);
                                                    } else {
                                                        echo $empty_answer;
                                                    }
                                                    ?>
												</p>
                                                <p class="rb_company_input_data">
													<span class="rb_company_input_head">  Vets/Discounts: </span><?php
                                                    if (isset($info['financial_veterandiscounts']) && ($info['financial_veterandiscounts']) != '') {
                                                        echo getTypeText($info['financial_veterandiscounts']);
                                                    } else {
                                                        echo $empty_answer;
                                                    }
                                                    ?>
												</p>
                                                <p class="rb_company_input_data">
													<span class="rb_company_input_head">Describe Discounts:  </span><?php
                                                    if (isset($info['financial_describediscounts']) && ($info['financial_describediscounts']) != '') {
                                                        echo $info['financial_describediscounts'];
                                                    } else {
                                                        echo $empty_answer;
                                                    }
                                                    ?>
												</p> 
												
                                                <p class="rb_company_input_data">
													<span class="rb_company_input_head"> Financing internally: </span><?php
                                                    if (isset($info['financial_internalfinancing']) && ($info['financial_internalfinancing']) != '') {
                                                        echo getTypeText($info['financial_internalfinancing']);
                                                    } else {
                                                        echo $empty_answer;
                                                    }
                                                    ?>
												</p>
												<p class="rb_company_input_data">
													<span class="rb_company_input_head"> Describe Internal Financing: </span>
													<?php if ($info['financial_internalfinancing']==1 && isset($info['financial_internalfinancingfile']) && ($info['financial_internalfinancingfile']) != '') { ?>
													<a target="_BLANK" href="<?php echo wp_get_attachment_url($info['financial_internalfinancingfile']); ?>" class=""><span>View File</span></a>
													<?php } else {
															echo $empty_answer;
														}
													?>
												</p>
												
                                            </div>
											<div class="col-sm-12 col-md-12">
											<p class="text-right rb_edit_button">
												<?php
												$edit_avail_base['current_step']=7;
												$edit_avail_base['set_bookmark']='salesprocess_registeredStatesType';
												$company_edit=getCompanyEditlink($company_edit_url,$edit_avail_base);
												?>												
												<a href="<?php echo $company_edit; ?>" class="btn btn-info btn-sm" role="button">Edit</a>
                                            </p>

											<p class="rb_company_heading">AVAILABILITY</p>
											<p class="rb_company_input_data">
												<span class="rb_company_input_head"> Registered in all states except:</span>
												<?php
												if (isset($info['salesprocess_notRegisteredStates']) && ($info['salesprocess_notRegisteredStates']) != '' && count($info['salesprocess_notRegisteredStates']) > 0 && $info['salesprocess_registeredStatesType'] == 2) {
													$categories = getexplodeData($info['salesprocess_notRegisteredStates'], 'name', 'location', 'location_id');
													echo implode(", ", $categories);
												} else {
													echo $empty_answer;
												}
												?>	
											</p>
											<p class="rb_company_input_data">   <span class="rb_company_input_head"> International:  </span>
												<?php
												if (isset($info['salesprocess_operationcountries']) && ($info['salesprocess_operationcountries']) != '' && count($info['salesprocess_operationcountries']) > 0 && $info['salesprocess_operationotherCountriesType'] == 1) {
													$categories = getexplodeData($info['salesprocess_operationcountries'], 'name', 'location', 'location_id');
													echo implode(", ", $categories);
												} else {
													echo $empty_answer;
												}
												?>
											</p>		

											<p class="text-right rb_edit_button">
												<?php
												$edit_territory_base['current_step']=5;
												$edit_territory_base['set_bookmark']='brand_definedterritorytype';
												$company_edit=getCompanyEditlink($company_edit_url,$edit_territory_base);
												?>												
												<a href="<?php echo $company_edit; ?>" class="btn btn-info btn-sm" role="button">Edit</a>
                                            </p>
											
                                            <p class="rb_company_heading">TERRITORY</p>
                                            <p class="rb_company_input_data"><span class="rb_company_input_head">  Details:</span> <?php
                                                if (isset($info['brand_definedterritory']) && ($info['brand_definedterritory']) != '' && $info['brand_definedterritorytype'] == 1) {
                                                    echo $info['brand_definedterritory'];
                                                } else {
                                                    echo $empty_answer;
                                                }
                                                ?>
											</p>
											
											<p class="rb_company_input_data">   <span class="rb_company_input_head"> These major market areas are sold out:  </span><?php
												if (isset($info['brand_listMarketsSoldOut']) && ($info['brand_listMarketsSoldOut']) != '') {
													echo $info['brand_listMarketsSoldOut'];
												} else {
													echo $empty_answer;
												}
												?>	
											</p	>

											<p class="rb_company_input_data">
												<span class="rb_company_input_head"> Currently targeting these markets: </span>
												<?php
												if (isset($info['brand_currentmarkettargetdesc']) && ($info['brand_currentmarkettargetdesc']) != '') { 
													echo $info['brand_currentmarkettargetdesc'];
													if (isset($info['brand_currentmarkettargetdocs']) && ($info['brand_currentmarkettargetdocs']) != '') { ?>
													<a target="_BLANK" href="<?php echo wp_get_attachment_url($info['brand_currentmarkettargetdocs']); ?>" class=""><span> View File</span></a>
												<?php 
													}
												}	
												if(empty($info['brand_currentmarkettargetdesc']) && empty($info['brand_currentmarkettargetdocs'])){
													echo $empty_answer;
												}
												?>
											</p>											
											
                                            <p class="text-right rb_edit_button">
												<?php
												$edit_businessbase['current_step']=5;
												$edit_businessbase['set_bookmark']='brand_yearconcept';
												$company_edit=getCompanyEditlink($company_edit_url,$edit_businessbase);
												?>												
                                                <a class="btn btn-info btn-sm" href="<?php echo $company_edit; ?>" role="button">Edit</a>
                                            </p>

                                            <p class="rb_company_heading">BUSINESS</p>
                                            <p class="rb_company_input_data"><span class="rb_company_input_head">  Founded:</span> <?php
                                                if (isset($info['brand_yearconcept']) && ($info['brand_yearconcept']) != '') {
                                                    echo $info['brand_yearconcept'];
                                                } else {
                                                    echo $empty_answer;
                                                }
                                                ?>
											</p>
                                            <p class="rb_company_input_data"><span class="rb_company_input_head">  Franchised:</span> <?php
                                                if (isset($info['brand_yearbeganfranchise']) && ($info['brand_yearbeganfranchise']) != '') {
                                                    echo $info['brand_yearbeganfranchise'];
                                                } else {
                                                    echo $empty_answer;
                                                }
                                                ?></p>
                                            <p class="rb_company_input_data"><span class="rb_company_input_head">  Open Units:</span> <?php
                                                if (isset($info['brand_openunits']) && ($info['brand_openunits']) != '') {
                                                    echo $info['brand_openunits'];
                                                } else {
                                                    echo $empty_answer;
                                                }
                                                ?></p>
                                            <p class="rb_company_input_data"><span class="rb_company_input_head">  Significant Changes Since Disclosure:</span> <?php
                                                if (isset($info['brand_commentopenunits']) && ($info['brand_commentopenunits']) != '') {
                                                    echo $info['brand_commentopenunits'];
                                                } else {
                                                    echo $empty_answer;
                                                }
                                                ?></p>

                                            <p class="rb_company_input_data"><span class="rb_company_input_head">What business does:</span><?php
                                                if (isset($info['brand_businessmodeldesc']) && ($info['brand_businessmodeldesc']) != '') {
                                                    echo $info['brand_businessmodeldesc'];
                                                } else {
                                                    echo $empty_answer;
                                                }
                                                ?>
											</p>											
											</div>
                                                <div class="col-sm-12 col-md-12">
												   <p class="text-right rb_edit_button">
														<?php
														$edit_owner_base['current_step']=5;
														$edit_owner_base['set_bookmark']='brand_ownercharacteristics';
														$company_edit=getCompanyEditlink($company_edit_url,$edit_owner_base);
														?>												   
														<a class="btn btn-info btn-sm" href="<?php echo $company_edit; ?>" role="button">Edit</a>
													</p>
													<p class="rb_company_heading">OWNER</p>
													<p class="rb_company_input_data"><span class="rb_company_input_head">Owner Role:</span><?php
														if (isset($info['brand_ownercharacteristics']) && ($info['brand_ownercharacteristics']) != '') {
															echo $info['brand_ownercharacteristics'];
														} else {
															echo $empty_answer;
														}
														?>
													</p>
													<p class="rb_company_input_data"><span class="rb_company_input_head">Sales Aptitude:</span><?php
														if (isset($info['brand_salesability']) && ($info['brand_salesability']) != '') {
															echo $info['brand_salesability'];
														} else {
															echo $empty_answer;
														}
														?></p>
													<p class="rb_company_input_data">
														<span class="rb_company_input_head">Business Model:  </span>
														<?php
														if (isset($info['brand_businessmodeltype']) && ($info['brand_businessmodeltype']) != '') {
															$business_model_arr = getBranBusinessModel($info['brand_businessmodeltype']);
															if (is_array($business_model_arr) && count($business_model_arr) > 0) {
																echo implode(', ', $business_model_arr);
															}
														} else {
															echo $empty_answer;
														}
														?>
													</p>
													<p class="rb_company_input_data"><span class="rb_company_input_head">Home Office:    </span><?php
														if (isset($info['brand_operationfromhome']) && ($info['brand_operationfromhome']) != '') {
															echo getTypeTextHome($info['brand_operationfromhome']);
														} else {
															echo $empty_answer;
														}
														?></p>
													<?php if (isset($info['brand_operationfromhome']) && $info['brand_operationfromhome'] === '3') { ?>
														<p class="rb_company_input_data"><span class="rb_company_input_head">Not Home Based: </span><?php
															if (isset($info['brand_locationType']) && ($info['brand_locationType']) != '') {
																echo $info['brand_locationType'];
															}
															?></p>
													<?php } ?>
													<?php if (isset($info['brand_locationType']) && $info['brand_locationType'] == 'Other') { ?>
														<p class="rb_company_input_data"><span class="rb_company_input_head">Other:  </span><?php
															if (isset($info['brand_locationRequirementsDesc']) && ($info['brand_locationRequirementsDesc']) != '') {
																echo $info['brand_locationRequirementsDesc'];
															}
															?></p>
													<?php } ?>
													<p class="rb_company_input_data"><span class="rb_company_input_head">Hours of Operation:  </span><?php
														if (isset($info['brand_operationhours']) && ($info['brand_operationhours']) != '') {
															echo getBrandOperationsHours($info['brand_operationhours']);
														} else {
															echo $empty_answer;
														}
														?></p>
													<p class="rb_company_input_data"><span class="rb_company_input_head">Primary Customer/End User:</span><?php
														if (is_array($info['brand_primarycustomer']) && count($info['brand_primarycustomer'])>0) {
															$brand_primarycustomer = implode(", ", $info['brand_primarycustomer']);
															echo $brand_primarycustomer;
															
														} else {
															echo $empty_answer;
														}
														?>
													</p>
                                                </div>
                                     <div class="col-sm-12 col-md-12">
                                            <p class="text-right rb_edit_button">
												<?php
												$edit_training_base['current_step']=7;
												$edit_training_base['set_bookmark']='salesprocess_trainingDesc';
												$company_edit=getCompanyEditlink($company_edit_url,$edit_training_base);
												?>												
                                                <a class="btn btn-info btn-sm" href="<?php echo $company_edit; ?>" role="button">Edit</a>
                                            </p>
                                            <p class="rb_company_heading">TRAINING</p>
                                            <p class="rb_company_input_data"><?php
                                                if (isset($info['salesprocess_trainingDesc']) && ($info['salesprocess_trainingDesc']) != '') {
                                                    echo $info['salesprocess_trainingDesc'];
                                                } else {
                                                    echo $empty_answer;
                                                }
                                                ?></p>
                                        </div>
										<div class="col-sm-12 col-md-12">
                                            <p class="text-right rb_edit_button">
												<?php
												$edit_base['current_step']=9;
												$company_edit=getCompanyEditlink($company_edit_url,$edit_base);
												?>													
                                                <a class="btn btn-info btn-sm" href="<?php echo $company_edit; ?>" role="button">Edit</a>
                                            </p>
                                            <p class="rb_company_heading">ADDITIONAL NOTES AND DOWNLOADS</p>
																						
                                            <p class="rb_company_input_data"><span class="rb_company_input_head">Standard Sales Process - 1-initial overview; 2-FDD review; 3-validation; 4-discovery day/executive interviews; 5-award:</span> <?php
                                                if (isset($info['salesprocess_standardizedstepstype']) && ($info['salesprocess_standardizedstepstype']) != '') {
                                                    echo getTypeText($info['salesprocess_standardizedstepstype']);
                                                } else {
                                                    echo $empty_answer;
                                                }
                                                ?>
											</p>
                                            <p class="rb_company_input_data"><span class="rb_company_input_head">Sales Process if non-standard:</span><?php
                                                if (isset($info['salesprocess_developmentExpectations']) && ($info['salesprocess_developmentExpectations']) != '' && $info['salesprocess_standardizedstepstype']==2) {
                                                    echo $info['salesprocess_developmentExpectations'];
                                                } else {
                                                    echo $empty_answer;
                                                }
                                                ?>
											</p>
                                            <p class="rb_company_input_data">
												<span class="rb_company_input_head">Outline of Sales/Development Process</span>
												<?php if (isset($info['uploads_outlineOfSales']) && ($info['uploads_outlineOfSales']) != '') {
                                                    ?>
                                                    <a target="_BLANK" href="<?php echo wp_get_attachment_url($info['uploads_outlineOfSales']); ?>" class=""><span>View File</span></a>
                                                <?php }else{
													echo $empty_answer;
												}
												?>
                                            </p>
											
                                            <p class="rb_company_input_data"><span class="rb_company_input_head">Validation Preparation:</span><?php
                                                if (isset($info['salesprocess_validationPreparation']) && ($info['salesprocess_validationPreparation']) != '') {
                                                    echo $info['salesprocess_validationPreparation'];
                                                } else {
                                                    echo $empty_answer;
                                                }
                                                ?>
											</p>										

                                            <p class="rb_company_input_data"><span class="rb_company_input_head">Two Minute Drill / One Sheet:  </span>
												<?php if (isset($info['uploads_twoMinDrill']) && ($info['uploads_twoMinDrill']) != '') {
                                                    ?>
                                                    <a target="_BLANK" href="<?php echo wp_get_attachment_url($info['uploads_twoMinDrill']); ?>" class=""><span>View File</span></a>
                                                <?php } else {
                                                    echo $empty_answer;
                                                }  ?>
											</p>
											
                                            <p class="rb_company_input_data">
												<span class="rb_company_input_head">PowerPoint  Presentation: </span><?php if (isset($info['uploads_powerPointPresentation']) && ($info['uploads_powerPointPresentation']) != '') { ?>
                                                    <a href="<?php echo wp_get_attachment_url($info['uploads_powerPointPresentation']); ?>" class=""><span>View File</span></a>
                                                <?php } else {
                                                    echo $empty_answer;
                                                } ?>
											</p>

                                            <p class="rb_company_input_data">
												<span class="rb_company_input_head">Video:</span>
												<?php if (isset($info['uploads_Video']) && ($info['uploads_Video']) != '') { ?>
                                                    <a target="_BLANK" href="<?php echo $info['uploads_Video']; ?>"  class=""><span><?php echo $info['uploads_Video']; ?></span></a>
                                                <?php } else {
                                                    echo $empty_answer;
                                                }  ?>
											</p>
                                            <p class="rb_company_input_data"><span class="rb_company_input_head">Active Resales:</span><?php if (isset($info['uploads_listActiveResale']) && ($info['uploads_listActiveResale']) != '') { ?>
                                                    <a target="_BLANK" href="<?php echo wp_get_attachment_url($info['uploads_listActiveResale']); ?>" class=""><span>View File</span></a>
                                                <?php }else {
                                                    echo $empty_answer;
                                                } ?>
											</p>
                                            <p class="rb_company_input_data">
												<span class="rb_company_input_head">Deal Announcements:</span><?php if (isset($info['uploads_dealAnnouncements']) && ($info['uploads_dealAnnouncements']) != '') { ?>
                                                    <a target="_BLANK" href="<?php echo wp_get_attachment_url($info['uploads_dealAnnouncements']); ?>" class=""><span>View File</span></a>
                                                <?php }else {
                                                    echo $empty_answer;
                                                }  ?>
											</p>
                                            <p class="rb_company_input_data">
												<span class="rb_company_input_head">Other:</span>

                                                <?php if (isset($info['uploads_company_Other_file_1']) && ($info['uploads_company_Other_file_1']) != '') { ?>
                                                    <br/>
                                                    <a href="<?php echo wp_get_attachment_url($info['uploads_company_Other_file_1']); ?>" class=""><span>View File</span></a>
                                                <?php }
                                                ?><?php
                                                if (isset($info['uploads_company_Otherlabel_1']) && ($info['uploads_company_Otherlabel_1']) != '') {
                                                    echo '<span> - ' . $info['uploads_company_Otherlabel_1'] . '</span>';
                                                }
                                                ?>

                                                <?php if (isset($info['uploads_company_Other_file_2']) && ($info['uploads_company_Other_file_2']) != '') { ?>
                                                    </br>
                                                    <a target="_BLANK" href="<?php echo wp_get_attachment_url($info['uploads_company_Other_file_2']); ?>" class=""><span>View File</span></a>
                                                <?php }
                                                ?><?php
                                                if (isset($info['uploads_company_Otherlabel_2']) && ($info['uploads_company_Otherlabel_2']) != '') {
                                                    echo '<span> - ' . $info['uploads_company_Otherlabel_2'] . '</span>';
                                                }
                                                ?>
                                                <?php if (isset($info['uploads_company_Other_file_3']) && ($info['uploads_company_Other_file_3']) != '') { ?>
                                                    </br>
                                                    <a target="_BLANK" href="<?php echo wp_get_attachment_url($info['uploads_company_Other_file_3']); ?>" class=""><span>View File</span></a>
                                                <?php }
                                                ?><?php
                                                if (isset($info['uploads_company_Otherlabel_3']) && ($info['uploads_company_Otherlabel_3']) != '') {
                                                    echo '<span> - ' . $info['uploads_company_Otherlabel_3'] . '</span>';
                                                }
                                                ?>
                                                <?php if (isset($info['uploads_company_Other_file_4']) && ($info['uploads_company_Other_file_4']) != '') { ?>
                                                    </br>
                                                    <a target="_BLANK" href="<?php echo wp_get_attachment_url($info['uploads_company_Other_file_4']); ?>" class=""><span>View File</span></a>
                                                <?php }
                                                ?><?php
                                                if (isset($info['uploads_company_Otherlabel_4']) && ($info['uploads_company_Otherlabel_4']) != '') {
                                                    echo '<span> - ' . $info['uploads_company_Otherlabel_4'] . '</span>';
                                                }
                                                ?>

                                                <?php if (isset($info['uploads_company_Other_file_5']) && ($info['uploads_company_Other_file_5']) != '') { ?>
                                                    </br>
                                                    <a target="_BLANK" href="<?php echo wp_get_attachment_url($info['uploads_company_Other_file_5']); ?>" class=""><span>View File</span></a>
                                                <?php }
                                                ?><?php
                                                if (isset($info['uploads_company_Otherlabel_5']) && ($info['uploads_company_Otherlabel_5']) != '') {
                                                    echo '<span> - ' . $info['uploads_company_Otherlabel_5'] . '</span>';
                                                }
                                                ?>
                                            </p>
                                            <p class="rb_company_input_data"><b>This information has been provided by the Company and is believed to be current information. However, if you have any questions or want to check accuracy of any information you are encouraged to speak directly to a Company representative.</b></p>
                                        </div>
                                   
                                        </div>
                                    </div >

                                    <div class="row rb_company_landingrow">
									   <div class="col-sm-12 col-md-12">
                                        <div class="col-sm-5 col-md-4 rb_landingleft_row_foo">
                                            <p class="rb_company_input_data">												
                                                <span class="">*Information in italics can only be edited by FranBrokers.</span><br/> Copyright 2015 FranBrokers Consortium, llc.<br/>All Rights Reserved
											</p>
                                        </div>
                                        <div class="col-sm-7 col-md-8 rb_landingright_row_foo">
                                            <p class="rb_company_input_data"><span class="rb_company_input_head">Print Date:</span><?php echo date("m-d-Y"); ?></p>
                                        </div>
										</div>
                                    </div>
									<div class="row">
                                        <div class="col-sm-12 col-md-12 welcome_rightsection text-right">
											<a class="btn btn-primary btn-md" href="<?php echo $company_portal_url;?>" role="button">Return to Portal Homepage</a><br/>
											<a class="btn btn-info btn-md btn-returntop" href="#top" role="button">Return to Top</a>									
										</div>												
									</div>


                                </div>
                            </div> <!-- .et_pb_text -->
                        </div> <!-- .et_pb_column -->
                    </div> <!-- .et_pb_row -->

                </div>
            </div>
        </div>
    </article>
</div><!-- end of #content -->
<script>
    jQuery(document).ready(function() {
        jQuery('span.rb_number').number(true, 0);
    });
</script>

<?php get_footer(); ?>
