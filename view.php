<?php
require_once('../../config.php');
require_login();
global $DB, $OUTPUT, $PAGE;

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/blocks/student_registration/view.php');
$PAGE->set_title(get_string('registeredstudents', 'block_student_registration'));
$PAGE->set_heading(get_string('registeredstudents', 'block_student_registration'));

$students = $DB->get_records('block_student_registration', null, 'id DESC');

echo $OUTPUT->header();
echo html_writer::tag('h3', get_string('registeredstudents', 'block_student_registration'));

$addurl = new moodle_url('/blocks/student_registration/addstudent.php');
echo html_writer::div(html_writer::link($addurl, get_string('addstudent', 'block_student_registration')), 'mb-3');

$table = new html_table();
$table->head = [get_string('fullname', 'block_student_registration'), get_string('email', 'block_student_registration'),
                get_string('contact', 'block_student_registration'), get_string('school', 'block_student_registration'),
                get_string('batch', 'block_student_registration'), ''];
$table->data = [];

foreach ($students as $student) {
    $editurl = new moodle_url('/blocks/student_registration/editstudent.php', ['id' => $student->id]);
    $deleteurl = new moodle_url('/blocks/student_registration/deletestudent.php', ['id' => $student->id]);

    $actions = html_writer::link($editurl, get_string('edit', 'block_student_registration')) . ' | ' .
               html_writer::link($deleteurl, get_string('deletestudent', 'block_student_registration'),
                    ['onclick' => "return confirm('".get_string('confirmdelete', 'block_student_registration')."');"]);

    $table->data[] = [
        format_string($student->fullname),
        s($student->email),
        s($student->contact),
        s($student->school),
        s($student->batch),
        $actions
    ];
}

echo html_writer::table($table);
echo $OUTPUT->footer();
