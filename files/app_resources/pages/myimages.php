<?php
if (!$futurebb_user['g_upload_images']) {
	httperror(403);
}
if ($futurebb_user['g_admin_privs'] && isset($_GET['user'])) {
	$user = intval($_GET['user']);
	$result = $db->query('SELECT username FROM `#^users` WHERE id=' . $user) or enhanced_error('Failed to get username', true);
	if (!$db->num_rows($result)) {
		httperror(404);
	}
	list($username) = $db->fetch_row($result);
} else {
	$user = $futurebb_user['id'];
}
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page_title = 'My images';
?>
<h2><?php echo ($user == $futurebb_user['id'] ? 'My' : $username . '&apos;s'); ?> images</h2>
<?php
$result = $db->query('SELECT 1 FROM `#^userimages` WHERE user=' . $user) or enhanced_error('Failed to get recent images', true);
$num_images = $db->num_rows($result);

$result = $db->query('SELECT id,extension,time,filename,ip_addr FROM `#^userimages` WHERE user=' . $user . ' ORDER BY time DESC LIMIT ' . (20 * ($page - 1)) . ',20') or enhanced_error('Failed to get recent images', true);
if ($db->num_rows($result)) {
	echo '<p>Pages: ' . paginate('<a href="' . $base_config['baseurl'] . '/' .  htmlspecialchars($dirs[1]) . '?page=$page$"$bold$>$page$</a>', $page, ceil($num_images / 20)) . '</p>';
	echo '<table border="0px">';
	echo '<tr><th>Image</th><th>Time</th>';
	if ($futurebb_user['g_admin_privs'] || ($futurebb_user['g_mod_privs'] && $futurebb_user['g_mod_view_ip'])) {
		echo '<th>IP address</th>';
	}
	echo '<th>Code</th></tr>';
	while ($img = $db->fetch_assoc($result)) {
		echo '<tr>
			<td><img src="' . htmlspecialchars($base_config['baseurl']) . '/static/userimages/' . $img['id'] . '.' . $img['extension'] . '" alt="' . htmlspecialchars($img['filename']) . '" style="max-width:48px; max-height:48px" /></td>
			<td>' . user_date($img['time']) . '</td>';
			if ($futurebb_user['g_admin_privs'] || ($futurebb_user['g_mod_privs'] && $futurebb_user['g_mod_view_ip'])) {
				echo '<td><a href="' . $base_config['baseurl'] . '/admin/ip_tracker?ip=' . htmlspecialchars(rawurlencode($img['ip_addr'])) . '">' . htmlspecialchars($img['ip_addr']) . '</a></td>';
			}
			echo '<td><input type="text" readonly="readonly" value="[img]' . htmlspecialchars($base_config['baseurl']) . '/static/userimages/' . $img['id'] . '.' . $img['extension'] . '[/img]" size="50" /></td>
		</tr>';
	}
	echo '</table>';
} else {
	echo '<p>No images found!</p>';
}