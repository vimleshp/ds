<?php 
    require_once("dealsector.php");
    $exisitingclientapiurl = '';
    $exisitingclientkey = '';
    $updateMsg = '';
	$exisitingfinancelink = '';
    $records_to_show = 5;
    if($wpdb->get_var( "show tables like '".DEALSECTOR_CLIENT_TABLE."'" ) == DEALSECTOR_CLIENT_TABLE) {
      $isrecordfound = $wpdb->get_results( "SELECT * FROM ".DEALSECTOR_CLIENT_TABLE );
      if( isset($isrecordfound[0]) ){
        $exisitingclientapiurl=$isrecordfound[0]->api_link;
		$exisitingclientkey = $isrecordfound[0]->key;
        $records_to_show = $isrecordfound[0]->records_to_show;
		$exisitingfinancelink = $isrecordfound[0]->finance_link;
      }
    }
    if($wpdb->get_var( "show tables like '".DEALSECTOR_SHORTCODE_TEMPLATE."'" ) == DEALSECTOR_SHORTCODE_TEMPLATE) {
      $isShortcodeFound = $wpdb->get_results( "SELECT * FROM ".DEALSECTOR_SHORTCODE_TEMPLATE );
    }
    if(isset($_POST["submitEditShortcode"])){
      if(isset($_POST["edit_sc_id"]) && isset($_POST["edit_sc_template"])){
        try{
          $sc_id = $_POST["edit_sc_id"];
          $sc_template = $_POST["edit_sc_template"];
          $sc_desc = $_POST["edit_sc_desc"];
          $wpdb->update( DEALSECTOR_SHORTCODE_TEMPLATE, array('shortcode_template_id' => $sc_template, 'shortcode_description' => $sc_desc), array('id' => $sc_id ));
          $isShortcodeFound = $wpdb->get_results( "SELECT * FROM ".DEALSECTOR_SHORTCODE_TEMPLATE );
          $updateMsg = "Shortcode template updated.";
        }catch(Exception $e){
          $updateMsg = "Something went wrong. Try again!!";
        }
      }
    }

    if(isset($_POST['submitCss'])){
      $file = fopen(DEALSECTOR__PLUGIN_DIR.'includes/dscustom.css',"w");
      fwrite($file,$_POST['custom_css']);
      fclose($file);
      $message_css='Custom css saved successfully';
      echo '<div class="notice is-dismissible notice-info customcss"><p>'.$message_css.'</p><button type="button" class="notice-dismiss close"><span class="screen-reader-text">Dismiss this notice.</span></button></div>'; 
      
    }
?>
<div class="dealsector-container">
   <h1><img src="<?php echo DEALSECTOR__PLUGIN_BASE_URL.'includes/images/Dealsector_Logo.png' ?>" alt="Dealsector" width="200px" /></h1>
   <div class="container-1">
    <p id="response-message"><?php ?></p>
    <h3>API Settings:</h3>
    <form method="post" name="dealsectorClientKeyForm" id="dealsectorClientKeyForm">
      <label for="api_link"><b>API Link <span style="color:red;">*</span></b></label>
      <br>
      <input type="text" id="api_link" name="api_link" placeholder="API Link" value="<?php echo $exisitingclientapiurl;?>">
      <br><br>
      <label for="client_secret_key"><b>Key <span style="color:red;">*</span></b></label>
      <br>
      <input type="text" id="client_secret_key" name="client_secret_key" placeholder="Client Key" value="<?php echo $exisitingclientkey;?>">
      <br><br>
      <label for="records_to_show"><b>Number of records</b></label>
      <br>
      <input type="number" id="records_to_show" name="records_to_show" placeholder="Number of records to show" value="<?php echo $records_to_show;?>">
      <br><br>
      <label for="currency"><b>Currency <span style="color:red;">*</span></b></label>
      <br>
      <select id="currency" name="currency"><option value="$">Dollar</option></select>
      <br><br>
		<label for="finance_link"><b>Finance Link <span style="color:red;">*</span></b></label>
      <br>
      <input type="text" id="finance_link" name="finance_link" placeholder="Finance Link" value="<?php echo $exisitingfinancelink;?>">
      <br><br>
      <input type="submit" id="submitclientkey" name="submitclientkey" value="Submit">
    </form>
    
    <h3>Store Locations</h3>
    <form method="post" name="dealsectorStoreLocationForm" id="dealsectorStoreLocationForm">
    	<input type="submit" id="submitStoreLocation" name="submitStoreLocation" value="Sync Store Locations">
    </form>
    <p>Click on this button to synchronize the store locations with OPS Site. </p>
    <h3>Add Shortcode:</h3>
    <form method="post" name="dealsectorAddShortcodeForm" id="dealsectorAddShortcodeForm">
      <label for="sc_title"><b>Shortcode Title <span style="color:red;">*</span></b></label>
      <br>
      <input type="text" id="sc_title" name="sc_title" placeholder="Shortcode Title" value="">
      <br><br>
      <label for="sc_code"><b>Shortcode Code <span style="color:red;">*</span></b></label>
      <br>
      <input type="text" id="sc_code" name="sc_code" placeholder="Shortcode Code" value="">
      <br><br>
      <label for="sc_template"><b>Shortcode Template ID <span style="color:red;">*</span></b></label>
      <br>
      <input type="text" id="sc_template" name="sc_template" placeholder="Shortcode Template ID" value="">
      <br><br>
      <label for="sc_desc"><b>Shortcode Description <span style="color:red;">*</span></b></label>
      <br>
      <textarea id="sc_desc" name="sc_desc" placeholder="Shortcode Description" rows="6" value=""></textarea>
      <br><br>
      <input type="submit" id="submitAddShortcode" name="submitAddShortcode" value="Submit">
    </form>
    <div>
      <h3>Custom CSS:</h3>
      <form action="" method="POST" id="cssForm">
      <div>
        <textarea name="custom_css" rows="5" style="width:94%;"><?php echo file_get_contents(DEALSECTOR__PLUGIN_DIR.'includes/dscustom.css');?></textarea>
      </div>
      <div style="margin-top:10px;">
        <input type="submit" id="submitCss" name="submitCss" value="Submit">
      </div>
      </form>
   </div>
   </div>
   <div class="container-2">
      <h3>Edit Shortcode:</h3>
      <p id="update-response-message"><?php echo $updateMsg; ?></p>
      <?php if(count($isShortcodeFound)){ 
        foreach($isShortcodeFound as $key => $value){
      ?>
      <p><b>Title: </b><?php echo $value->shortcode_title; ?></p>
      <p><b>Code: </b><?php echo $value->shortcode_code; ?></p>
      <form method="post" class="dealsectorEditShortcode" name="dealsectorEditShortcode<?php echo $key;?>" id="dealsectorEditShortcode<?php echo $key;?>">
        <input type="hidden" name="edit_sc_id" value="<?php echo $value->id; ?>">
        <textarea name="edit_sc_desc" placeholder="Shortcode Description" rows="6"><?php echo $value->shortcode_description; ?></textarea>
        <input type="text" name="edit_sc_template" placeholder="Shortcode Template ID" value="<?php echo $value->shortcode_template_id;?>">
        <input type="submit" name="submitEditShortcode" value="Submit">
      </form>
      <?php if($value->shortcode_template_id != ""){ echo "<a target='_blank' href=".get_edit_post_link($value->shortcode_template_id).">".get_edit_post_link($value->shortcode_template_id)."</a>"; } ?>
      <hr>
      <?php }}?>
   </div>
</div>