<?php
require('../../config.php');
require_login();
redirect(new moodle_url('/blocks/student_registration/view.php'));
