<?php
if (!$futurebb_user['g_admin_privs']) {
	httperror(403);
}
translate('<addfile>', 'admin');
$page_title = 'Image Uploading';
include FORUM_ROOT . '/app_resources/includes/admin.php';
?>
<h2>Image uploading</h2>
<ul>
<li>Image maximum size, width, height</li>
</ul>