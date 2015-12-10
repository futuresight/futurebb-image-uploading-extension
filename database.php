<?php
if ($futurebb_user['language'] != 'English') {
	$error = 'This extension only works in English. Please change your language.';
	return;
}
ExtensionConfig::add_language_key('imageuploading', 'Image Uploading', 'English');
ExtensionConfig::add_page('/extensions/uploadimage', array('file' => 'uploadimage.php', 'template' => false, 'nocontentbox' => true));
mkdir(FORUM_ROOT . '/static/userimages');
ExtensionConfig::add_page('/admin/imageuploading', array('file' => 'admin/imageuploading.php', 'template' => true, 'nocontentbox' => true, 'admin' => true));
ExtensionConfig::add_admin_menu('imageuploading', 'imageuploading');
