<?php
require_once('../../config.php');
require_login();
global $DB, $PAGE, $OUTPUT, $CFG;

$id = required_param('id', PARAM_INT);
$record = $DB->get_record('block_student_registration', ['id' => $id], '*', IGNORE_MISSING);
if (!$record) {
    redirect(new moodle_url('/blocks/student_registration/view.php'), get_string('recordnotfound', 'block_student_registration'));
}

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/blocks/student_registration/editstudent.php', ['id' => $id]));
$PAGE->set_title(get_string('updatestudent', 'block_student_registration'));
$PAGE->set_heading(get_string('updatestudent', 'block_student_registration'));

require_once("$CFG->libdir/formslib.php");

class block_sr_edit_form extends moodleform {
    public function definition() {
        $mform = $this->_form;
        $mform->addElement('hidden', 'id');
        $mform->setType('id', PARAM_INT);

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

        $this->add_action_buttons(true, get_string('updatestudent', 'block_student_registration'));
    }
}

$mform = new block_sr_edit_form();

// Prepare defaults
$defaults = (array)$record;
if (!empty($record->dob) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $record->dob)) {
    $defaults['dob'] = strtotime($record->dob);
}
$mform->set_data($defaults);

if ($mform->is_cancelled()) {
    redirect(new moodle_url('/blocks/student_registration/view.php'));
} else if ($data = $mform->get_data()) {
    if (!empty($data->dob)) {
        $data->dob = date('Y-m-d', $data->dob);
    } else {
        $data->dob = null;
    }
    $DB->update_record('block_student_registration', $data);
    redirect(new moodle_url('/blocks/student_registration/view.php'), get_string('studentupdated', 'block_student_registration'));
}

echo $OUTPUT->header();
$mform->display();
echo $OUTPUT->footer();
