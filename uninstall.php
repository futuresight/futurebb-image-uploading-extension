<?php
ExtensionConfig::remove_language_key('imageuploading');
ExtensionConfig::remove_page('/extensions/uploadimage');
ExtensionConfig::remove_page('/admin/imageuploading', array('file' => 'admin/imageuploading.php', 'template' => true, 'nocontentbox' => true, 'admin' => true));
ExtensionConfig::remove_admin_menu('imageuploading');
ExtensionConfig::remove_page('/myimages');

$db->query('DELETE FROM `#^config` WHERE c_name IN(\'user_image_maxwidth\', \'user_image_maxheight\', \'user_image_maxsize\')') or enhanced_error('Failed to delete config entries', true);

$db->drop_table('userimages');

$db->drop_field('user_groups', 'g_upload_images');

unlink(FORUM_ROOT . '/app_resources/pages/myimages.php');
unlink(FORUM_ROOT . '/app_resources/pages/uploadimage.php');
unlink(FORUM_ROOT . '/app_resources/pages/admin/imageuploading.php');