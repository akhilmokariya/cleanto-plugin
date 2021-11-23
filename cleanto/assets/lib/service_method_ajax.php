<?php  include(dirname(dirname(dirname(__FILE__)))."/objects/class_services_methods.php");include(dirname(dirname(dirname(__FILE__)))."/objects/class_services.php");include(dirname(dirname(dirname(__FILE__)))."/objects/class_connection.php");include(dirname(dirname(dirname(__FILE__))).'/objects/class_setting.php');include(dirname(dirname(dirname(__FILE__)))."/header.php");$con = new cleanto_db();$conn = $con->connect();$objservice_method = new cleanto_services_methods();$objservice_method->conn = $conn;$objservice = new cleanto_services();$objservice->conn = $conn;$settings = new cleanto_setting();$settings->conn = $conn;$lang = $settings->get_option("ct_language");$label_language_values = array();$language_label_arr = $settings->get_all_labelsbyid($lang);if ($language_label_arr[1] != "" || $language_label_arr[3] != "" || $language_label_arr[4] != "" || $language_label_arr[5] != ""){	$default_language_arr = $settings->get_all_labelsbyid("en");	if($language_label_arr[1] != ''){		$label_decode_front = base64_decode($language_label_arr[1]);	}else{		$label_decode_front = base64_decode($default_language_arr[1]);	}	if($language_label_arr[3] != ''){		$label_decode_admin = base64_decode($language_label_arr[3]);	}else{		$label_decode_admin = base64_decode($default_language_arr[3]);	}	if($language_label_arr[4] != ''){		$label_decode_error = base64_decode($language_label_arr[4]);	}else{		$label_decode_error = base64_decode($default_language_arr[4]);	}	if($language_label_arr[5] != ''){		$label_decode_extra = base64_decode($language_label_arr[5]);	}else{		$label_decode_extra = base64_decode($default_language_arr[5]);	}		$label_decode_front_unserial = unserialize($label_decode_front);	$label_decode_admin_unserial = unserialize($label_decode_admin);	$label_decode_error_unserial = unserialize($label_decode_error);	$label_decode_extra_unserial = unserialize($label_decode_extra);    	$label_language_arr = array_merge($label_decode_front_unserial,$label_decode_admin_unserial,$label_decode_error_unserial,$label_decode_extra_unserial);		foreach($label_language_arr as $key => $value){		$label_language_values[$key] = urldecode($value);	}}else{    $default_language_arr = $settings->get_all_labelsbyid("en");    	$label_decode_front = base64_decode($default_language_arr[1]);	$label_decode_admin = base64_decode($default_language_arr[3]);	$label_decode_error = base64_decode($default_language_arr[4]);	$label_decode_extra = base64_decode($default_language_arr[5]);				$label_decode_front_unserial = unserialize($label_decode_front);	$label_decode_admin_unserial = unserialize($label_decode_admin);	$label_decode_error_unserial = unserialize($label_decode_error);	$label_decode_extra_unserial = unserialize($label_decode_extra);    	$label_language_arr = array_merge($label_decode_front_unserial,$label_decode_admin_unserial,$label_decode_error_unserial,$label_decode_extra_unserial);		foreach($label_language_arr as $key => $value){		$label_language_values[$key] = urldecode($value);	}}if (isset($_POST['getallservicemethod'])) {	    $objservice_method->service_id = $_POST['service_id'];    $res = $objservice_method->readall();    $i = 1;		/* ?>		<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/bootstrap-toggle.min.css" type="text/css" media="all">		<script src="<?php echo BASE_URL; ?>/assets/js/bootstrap-toggle.min.js" type="text/javascript" ></script>	<?php  */    while ($arrs = mysqli_fetch_array($res)) {        $i++;        ?>		<div class="col-sm-12 col-md-12 col-xs-12">			<li class="panel panel-default ct-clean-services-panel mysortlist_methods" data-id="<?php echo $arrs['id'];?>" id="service_method_<?php  echo $arrs['id'];?>">				<div class="panel-heading">					<h4 class="panel-title">						<div class="cta-col8 col-sm-6 np">							<div class="pull-left">								<i class="fa fa-th-list"></i>							</div>							<span class="ct-clean-service-title-name" id="service_name<?php  echo $arrs['id'];?>"><?php echo $arrs['method_title'];?></span>						</div>						<div class="pull-right cta-col4 col-sm-6 np">							<div class="cta-col4 cta-unit-pricing">								<a data-id="<?php echo $arrs['id'];?>" data-name="<?php echo $arrs['method_title'];?>"								   class="price-cal-method-btn pull-left btn-circle btn-success btn-sm mybtnforassignunits"								   title="<?php echo $label_language_values['manage_unit_price'];?>"> <i class="fa fa-tags" title="<?php echo $label_language_values['manage_unit_price'];?>"></i><?php echo $label_language_values['unit_pricing'];?></a>							</div>							<div class="cta-col4 cta-up-endis ta-r">								<label for="sevice-endis-<?php echo $arrs['id'];?>">									<input class='myservices_methods_status' data-toggle="toggle" data-size="small" type='checkbox' data-id="<?php echo $arrs['id'];?>" <?php  if ($arrs['status'] == 'E') { echo "checked"; } else { echo ""; }?> id="sevice-endis-<?php echo $arrs['id'];?>" data-on="<?php echo $label_language_values['enable'];?>" data-off="<?php echo $label_language_values['disable'];?>" data-onstyle='success' data-offstyle='danger' />								</label>							</div>							<div class="pull-right cta-unit-del-toggle">								<div class="cta-col1">								<?php 								$t = $objservice_method->method_isin_use($arrs['id']);								if($t>0){									?>									<a data-toggle="popover" class="delete-clean-service-btn pull-right btn-circle btn-danger btn-sm" rel="popover" data-placement='top' title="<?php echo $label_language_values['method_is_booked'];?>"> <i class="fa fa-ban"></i></a>								<?php 								}								else								{									?>									<a id="ct-delete-service-method<?php echo $arrs['id'];?>" data-toggle="popover"									   class="delete-clean-service-btn pull-right btn-circle btn-danger btn-sm"									   rel="popover" data-placement='left' title='<?php echo $label_language_values['delete_this_method'];?>'> 									   <i class="fa fa-trash" title="<?php echo $label_language_values['delete_service'];?>"></i></a>									<div id="popover-delete-service" style="display: none;">										<div class="arrow"></div>										<table class="form-horizontal" cellspacing="0">											<tbody>											<tr>												<td>													<button data-servicemethodid="<?php echo $arrs['id'];?>" value="Delete" class="btn btn-danger btn-sm service-methods-delete-button" type="submit"><?php echo $label_language_values['yes'];?></button>													<button id="ct-close-popover-delete-service-method" class="btn btn-default btn-sm" href="javascript:void(0)" data-servicemethodid="<?php echo $arrs['id'];?>"><?php echo $label_language_values['cancel'];?></button>												</td>											</tr>											</tbody>										</table>									</div>									<?php  }?>									<!-- end pop up -->								</div>								<div class="ct-show-hide pull-right">									<input type="checkbox" name="ct-show-hide" class="ct-show-hide-checkbox" id="sp<?php  echo $arrs['id'];?>"><!--Added Serivce Id-->									<label class="ct-show-hide-label" for="sp<?php  echo $arrs['id'];?>"></label>								</div>							</div>						</div>					</h4>				</div>				<div id="detailmes_sp<?php  echo $arrs['id'];?>" class="servicemeth_details panel-collapse collapse">				<div class="panel-body">						<div class="ct-service-collapse-div col-sm-7 col-md-7 col-lg-7 col-xs-12">							<form id="service_method_editform<?php  echo $arrs['id'];?>" method="post" type="" class="slide-toggle">								<table class="ct-create-service-table">									<tbody>									<tr>										<td><label for=""><?php echo $label_language_values['method_name'];?></label></td>										<td>											<div class="col-xs-12 col-sm-11"><input type="text" id="txtedtmethodname<?php  echo $arrs['id'];?>" class="form-control mytxtservice_methodname<?php  echo $arrs['id'];?>" value="<?php echo $arrs['method_title']?>"/>											</div>										</td>										<td>											<a data-id="<?php echo $arrs['id'];?>" name="" class="btn btn-success ct-btn-width btnservices_method_update"><?php echo $label_language_values['update'];?></a>										</td>									</tr>									</tbody>								</table>							</form>						</div>					</div>				</div>			</li>		</div>	    <?php     }    ?>	<div class="col-sm-12 col-md-12 col-xs-12">    <li>        <!-- add new clean service pop up -->        <div class="panel panel-default ct-clean-services-panel ct-add-new-price-method">            <div class="panel-heading">                <h4 class="panel-title">                    <div class="cta-col8">                        <span class="ct-service-title-name"></span>                    </div>                    <div class="pull-right cta-col4">                        <div class="pull-right">                            <div class="ct-show-hide pull-right">                                <input type="checkbox" name="ct-show-hide" checked="checked" class="ct-show-hide-checkbox" id="sp0"><!--Added Serivce Id-->                                <label class="ct-show-hide-label" for="sp0"></label>                            </div>                        </div>                    </div>                </h4>            </div>            <div id="" class="panel-collapse collapse in detail_sp0">                <div class="panel-body">                    <div class="ct-service-collapse-div col-sm-7 col-md-7 col-lg-7 col-xs-12">                        <form id="service_method_addform" method="post" type="" class="slide-toggle">                            <table class="ct-create-service-table">                                <tbody>                                <tr>                                    <td><label for=""><?php echo $label_language_values['method_name'];?></label></td>                                    <td>                                        <div class="col-xs-12 col-sm-11"><input type="text" id="txtmethodname" class="form-control mytxtservice_methodname"/> </div>                                    </td>                                    <td>                                        <a id="" name="" class="btn btn-success ct-btn-width btnservices_method"><?php echo $label_language_values['save'];?>  </a>                                    </td>                                </tr>                                </tbody>                            </table>                        </form>                    </div>                </div>            </div>        </div>    </li>	</div><?php } elseif(isset($_POST['pos']) && isset($_POST['ids'])){    echo "yes in ";    echo count((array)$_POST['ids']);    for($i=0;$i<count((array)$_POST['ids']);$i++)    {        $objservice_method->position=$_POST['pos'][$i];        $objservice_method->id=$_POST['ids'][$i];        $objservice_method->updateposition();    }}elseif (isset($_POST['action']) && $_POST['action']=='deletemethod') {    $objservice_method->id = $_POST['deletemethoid'];    $objservice_method->delete_services_method();		$methods_units = $objservice->get_exist_methods_units_by_methodid($_POST['deletemethoid']);		while($methods_units_arr = mysqli_fetch_array($methods_units))		{			$methods_units_rate = $objservice->get_exist_methods_units_rate_by_unitid($methods_units_arr['id']);			while($mur = mysqli_fetch_array($methods_units_rate))			{				/* Service method unit rate delete */				$objservice->delete_service_method_unit_rate($mur['id']);			}			/* Service method unit delete */			$objservice->delete_method_unit($methods_units_arr['id']);		}	   		/* Service method delete */		$objservice->delete_method($_POST['deletemethoid']);	} elseif (isset($_POST['changestatus'])) {    $objservice_method->id = $_POST['id'];    $objservice_method->status = $_POST['changestatus'];    $objservice_method->changestatus();	if($objservice_method){		if($_POST['changestatus']=='E'){			echo $label_language_values['method_enable'];		}else{			echo $label_language_values['method_disable'];		}	}} elseif (isset($_POST['operationinsert'])) {    $objservice_method->service_id = $_POST['service_id'];    $objservice_method->method_title = filter_var($_POST['name'], FILTER_SANITIZE_STRING);    $t = $objservice_method->check_same_title();    $cnt = mysqli_num_rows($t);    if($cnt == 0){    $objservice_method->service_id = $_POST['service_id'];    $objservice_method->method_title = filter_var(mysqli_real_escape_string($conn,ucwords($_POST['name'])), FILTER_SANITIZE_STRING);    $objservice_method->status = $_POST['status'];    $objservice_method->add_services_method();    }    else{        echo "1";    }}elseif(isset($_POST['operationedit'])){    $objservice_method->id = $_POST['id'];    $objservice_method->method_title = filter_var(mysqli_real_escape_string($conn,ucwords($_POST['method_title'])), FILTER_SANITIZE_STRING);    $objservice_method->update_services_method();}elseif(isset($_POST['operationgetmethods'])){    $objservice_method->service_id = $_POST['service_id'];    $res = $objservice_method->methodsbyserviceid();    while($arr = mysqli_fetch_array($res))    {        echo "Method : ".$arr['method_title']." Id ".$arr['id'];    }}?>