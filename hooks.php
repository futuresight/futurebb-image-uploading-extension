<?php
//the hooks file for the BBCode Toolbar extension
$hooks = array();
$hooks['bbcode_toolbar'] = array(
	function($args) {
		global $base_config;
		?>
		<iframe src="<?php echo $base_config['baseurl']; ?>/extensions/uploadimage" height="100px" width="650px" frameborder="0" id="uploadimageframe"></iframe>
		<script type="text/javascript">
		function resizeIframe(iframe) {
			iframe.height = (iframe.contentWindow.document.body.scrollHeight + 40) + "px";
		}
		var frame = document.getElementById('uploadimageframe');
		frame.onload = function() {
			resizeIframe(frame);
		}
		</script>
		<?php
	}
);