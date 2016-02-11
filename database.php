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
ExtensionConfig::add_page('/myimages', array('file' => 'myimages.php', 'template' => true));


$table = new DBTable('userimages');
$new_fld = new DBField('id','INT');
$new_fld->add_key('PRIMARY');
$new_fld->add_extra('NOT NULL');
$new_fld->add_extra('AUTO_INCREMENT');
$table->add_field($new_fld);
$new_fld = new DBField('filename','VARCHAR(256)');
$new_fld->add_extra('NOT NULL');
$table->add_field($new_fld);
$new_fld = new DBField('user','INT');
$new_fld->add_extra('NOT NULL');
$table->add_field($new_fld);
$new_fld = new DBField('ip_addr','VARCHAR(50)');
$new_fld->add_extra('NOT NULL');
$table->add_field($new_fld);
$new_fld = new DBField('time','INT');
$new_fld->add_extra('NOT NULL');
$table->add_field($new_fld);
$new_fld = new DBField('extension','VARCHAR(10)');
$new_fld->add_extra('NOT NULL');
$table->add_field($new_fld);
$table->commit();

$new_fld = new DBField('g_upload_images', 'TINYINT(1)');
$new_fld->add_extra('NOT_NULL');
$new_fld->set_default(0);
$db->add_field('user_groups', $new_fld, 'g_post_images');