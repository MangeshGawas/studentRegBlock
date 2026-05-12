<?php
require_once('../../config.php');
require_login();
global $DB, $PAGE, $OUTPUT, $CFG;
$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/blocks/student_registration/addstudent.php');
$PAGE->set_title(get_string('addstudent', 'block_student_registration'));
$PAGE->set_heading(get_string('addstudent', 'block_student_registration'));
require_once("$CFG->libdir/formslib.php");

class block_sr_student_form extends moodleform {
    public function definition() {
        $mform = $this->_form;

        $mform->addElement('text', 'fullname', get_string('fullname', 'block_student_registration'));
        $mform->setType('fullname', PARAM_TEXT);
        $mform->addRule('fullname', null, 'required', null, 'client');

        $mform->addElement('text', 'email', get_string('email', 'block_student_registration'));
        $mform->setType('email', PARAM_EMAIL);
        $mform->addRule('email', null, 'required', null, 'client');

        $mform->addElement('text', 'contact', get_string('contact', 'block_student_registration'));
        $mform->setType('contact', PARAM_TEXT);

        $mform->addElement('date_selector', 'dob', get_string('dob', 'block_student_registration'));

        $mform->addElement('text', 'standard', get_string('standard', 'block_student_registration'));
        $mform->setType('standard', PARAM_TEXT);

        $mform->addElement('text', 'batch', get_string('batch', 'block_student_registration'));
        $mform->setType('batch', PARAM_TEXT);

        $mform->addElement('text', 'day', get_string('day', 'block_student_registration'));
        $mform->setType('day', PARAM_TEXT);

        $mform->addElement('text', 'time', get_string('time', 'block_student_registration'));
        $mform->setType('time', PARAM_TEXT);

        $mform->addElement('text', 'school', get_string('school', 'block_student_registration'));
        $mform->setType('school', PARAM_TEXT);

        $this->add_action_buttons(true, get_string('savestudent', 'block_student_registration'));
    }
}

$mform = new block_sr_student_form();

if ($mform->is_cancelled()) {
    redirect(new moodle_url('/blocks/student_registration/view.php'));
} else if ($data = $mform->get_data()) {
    if (!empty($data->dob)) {
        $data->dob = date('Y-m-d', $data->dob);
    }
    $DB->insert_record('block_student_registration', $data);
    redirect(new moodle_url('/blocks/student_registration/view.php'), get_string('studentcreated', 'block_student_registration'));
}

echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
