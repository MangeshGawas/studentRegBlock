<?php
defined('MOODLE_INTERNAL') || die();
class block_student_registration extends block_base {
    public function init() {
        $this->title = get_string('pluginname', 'block_student_registration');
    }
    public function get_content() {
        global $OUTPUT;
        if ($this->content !== null) {
            return $this->content;
        }
        $this->content = new stdClass();
        $links = [];
        $links[] = html_writer::link(
            new moodle_url('/blocks/student_registration/addstudent.php'),
            get_string('addstudent', 'block_student_registration')
        );
        $links[] = html_writer::link(
            new moodle_url('/blocks/student_registration/view.php'),
            get_string('viewstudents', 'block_student_registration')
        );
        $this->content->text = html_writer::alist($links, null, 'ul');
        $this->content->footer = '';
        return $this->content;
    }
}
