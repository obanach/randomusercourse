<?php
defined('MOODLE_INTERNAL') || die;

$ADMIN->add('reports', new admin_externalpage('reportrandomusercourse', get_string('randomusercourse', 'report_randomusercourse'), "$CFG->wwwroot/report/randomusercourse/index.php"));

$settings = null;