<?php 
	if(!defined("_access")) {
		die("Error: You don't have permission to access here..."); 
	}

	$ID  	     = isset($data) ? recoverPOST("ID", 0) 								: 0;
	$title       = isset($data) ? recoverPOST("title", $data["Title"]) 				: recoverPOST("title");
	$content 	 = isset($data) ? recoverPOST("content", $data["Content"])		 	: recoverPOST("content");
	$tags    	 = isset($data) ? recoverPOST("tags", $data["Tags"]) 				: recoverPOST("tags");
	$language  	 = isset($data) ? recoverPOST("language", $data["Language"])  	 	: recoverPOST("language");
	$edit        = isset($data) ? TRUE 												: FALSE;
	$action	     = isset($data) ? "edit"											: "save";
	$href	     = path("blog/add/");
	
	echo div("add-form", "class");
		echo formOpen($href, "form-add", "form-add");
			echo p(__("Add new post"), "resalt");
			
			echo isset($alert) ? $alert : NULL;

			echo formInput(array(	
				"name" 	=> "title", 
				"class" => "required",
				"style" => "width: 100%;", 
				"field" => __("Title"), 
				"p" 	=> TRUE, 
				"value" => stripslashes($title)
			));

			$options = array(
				0 => array("value" => 1, "option" => "RedactorJS", "selected" => TRUE),
				1 => array("value" => 0, "option" => "markItUp!")
			);

			echo formSelect(array(
				"name" 	=> "editor", 
				"p" 	=> TRUE, 
				"field" => __("Editor")), 
				$options
			);
			
			echo formTextarea(array(
				"name" 	 => "content", 
				"class"  => "required",
				"style"  => "width: 100%; height: 240px;", 
				"field"  => __("Content"), 
				"p" 	 => TRUE, 
				"value"  => stripslashes($content)
			));

			echo formInput(array(	
				"name" 	=> "tags", 
				"class" => "required",
				"style" => "width: 300px;", 
				"field" => __("Tags"), 
				"p" 	=> TRUE, 
				"value" => $tags
			));

			$options = array(
				0 => array("value" => 1, "option" => __("Yes"), "selected" => TRUE),
				1 => array("value" => 0, "option" => __("No"))
			);

			echo formSelect(array(
				"name" 	=> "enable_comments", 
				"class" => "required", 
				"p" 	=> TRUE, 
				"field" => __("Enable Comments")), 
				$options
			);

			echo tagHTML("p", span("field", "&raquo; " . __("Language of the post")) . "<br />" . getLanguagesInput($language, "language", "select"));

			echo formInput(array(	
				"name" 	=> "save", 
				"class" => "btn btn-success", 
				"value" => __("Save"), 
				"type"  => "submit"
			));

			echo formInput(array(	
				"name" 	=> "preview", 
				"class" => "btn", 
				"value" => __("Preview"), 
				"type"  => "submit"
			));
			
			echo formInput(array("name" => "ID", "type" => "hidden", "value" => $ID));
		echo formClose();
	echo div(FALSE);
?>
<script>
$(document).ready(function() {
	$("textarea[name='content']").redactor();
});
</script>