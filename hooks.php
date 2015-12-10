<?php
//the hooks file for the BBCode Toolbar extension
$hooks = array();
$hooks['bbcode_toolbar'] = array(
	function($args) {
		?>
		<iframe src="<?php echo $base_config['baseurl']; ?>/extensions/uploadimage" height="40px" width="100px"></iframe>
		<?php
	}
);