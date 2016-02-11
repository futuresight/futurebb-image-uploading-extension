<?php
if (!$futurebb_user['g_admin_privs']) {
	httperror(403);
}
translate('<addfile>', 'admin');
$page_title = 'Image Uploading';
include FORUM_ROOT . '/app_resources/includes/admin.php';
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if (isset($_POST['form_sent'])) {
	set_config('user_image_maxwidth', $_POST['maxwidth']);
	set_config('user_image_maxheight', $_POST['maxheight']);
	set_config('user_image_maxsize', $_POST['maxsize']);
}
?>
<div class="container">
	<?php make_admin_menu(); ?>
	<div class="forum_content rightbox admin">
		<h2>Image uploading</h2>
		<h3>Options</h3>
		<form action="<?php echo $base_config['baseurl']; ?>/admin/imageuploading" method="post" enctype="multipart/form-data">
			<table border="0" class="optionstable">
				<tr>
					<th>Maximum width (pixels)</th>
					<td><input type="text" name="maxwidth" value="<?php echo intval($futurebb_config['user_image_maxwidth']); ?>" /></td>
				</tr>
				<tr>
					<th>Maximum height (pixels)</th>
					<td><input type="text" name="maxheight" value="<?php echo intval($futurebb_config['user_image_maxheight']); ?>" /></td>
				</tr>
				<tr>
					<th>Maximum size (KiB)</th>
					<td><input type="text" name="maxsize" value="<?php echo intval($futurebb_config['user_image_maxsize']); ?>" /></td>
				</tr>
			</table>
			<p><input type="submit" name="form_sent" value="Save" /></p>
		</form>
		<h3>Recent images</h3>
		<?php
		$result = $db->query('SELECT 1 FROM `#^userimages`') or enhanced_error('Failed to get recent images', true);
		$num_images = $db->num_rows($result);
		
		$result = $db->query('SELECT i.id,i.extension,i.time,i.filename,i.ip_addr,i.user,u.username FROM `#^userimages` AS i LEFT JOIN `#^users` AS u ON u.id=i.user ORDER BY time DESC LIMIT 20') or enhanced_error('Failed to get recent images', true);
		if ($db->num_rows($result)) {
			echo '<p>Pages: ' . paginate('<a href="' . $base_config['baseurl'] . '/' .  htmlspecialchars($dirs[1]) . '?page=$page$"$bold$>$page$</a>', $page, ceil($num_images / 20)) . '</p>';
			echo '<table border="0px">';
			echo '<tr><th>Image</th><th>Uploader</th><th>IP address</th><th>Time</th><th>Code</th></tr>';
			while ($img = $db->fetch_assoc($result)) {
				echo '<tr><td><img src="' . htmlspecialchars($base_config['baseurl']) . '/static/userimages/' . $img['id'] . '.' . $img['extension'] . '" alt="' . htmlspecialchars($img['filename']) . '" style="max-width:48px; max-height:48px" /></td><td><a href="' . $base_config['baseurl'] . '/users/' . htmlspecialchars(rawurlencode($img['username'])) . '">' . htmlspecialchars($img['username']) . '</a> (<a href="' . $base_config['baseurl'] . '/myimages?user=' . $img['user'] . '">images</a>)</td><td><a href="' . $base_config['baseurl'] . '/admin/ip_tracker?ip=' . htmlspecialchars(rawurlencode($img['ip_addr'])) . '">' . htmlspecialchars($img['ip_addr']) . '</a></td><td>' . user_date($img['time']) . '</td><td><input type="text" readonly="readonly" value="[img]' . htmlspecialchars($base_config['baseurl']) . '/static/userimages/' . $img['id'] . '.' . $img['extension'] . '[/img]" size="50" /></td></tr>';
			}
			echo '</table>';
		} else {
			echo '<p>No images found!</p>';
		}
		?>
	</div>
</div>