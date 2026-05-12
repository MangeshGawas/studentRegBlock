<?php
require_once('../../config.php');
require_login();
global $DB;

$id = required_param('id', PARAM_INT);

if ($DB->record_exists('block_student_registration', ['id' => $id])) {
    $DB->delete_records('block_student_registration', ['id' => $id]);
    redirect(new moodle_url('/blocks/student_registration/view.php'), get_string('studentdeleted', 'block_student_registration'));
} else {
    redirect(new moodle_url('/blocks/student_registration/view.php'), get_string('recordnotfound', 'block_student_registration'));
}
