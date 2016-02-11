<?php
//the hooks file for the BBCode Toolbar extension
$hooks = array();
$hooks['bbcode_toolbar'] = array(
	function($args) {
		global $base_config, $futurebb_user;
		if ($futurebb_user['g_upload_images']) {
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
	}
);
$hooks['group_options_bottom'] = array(
	function() {
		global $cur_group;
		?>
		<tr>
			<td>Upload images</td>
			<td><input type="checkbox" name="config[g_upload_images]" id="g_upload_images" <?php if ($cur_group['g_upload_images']) echo 'checked="checked" '; ?>/> <label for="g_upload_images"><?php echo translate('enable?'); ?></label><br />Allow direct uploading of images</td>
		</tr>
		<?php
	}
);
$hooks['group_options_submit'] = array(
	function() {
		global $cfg_list;
		$cfg_list['g_upload_images'] = 'bool';
	}
);