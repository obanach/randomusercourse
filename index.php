<?php
require(__DIR__.'/../../config.php');
require_once($CFG->libdir.'/adminlib.php');
require_once(__DIR__.'/classes/UserCourseTable.php');

admin_externalpage_setup('reportrandomusercourse', '', null, '', ['pagelayout' => 'report']);

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('table_title', 'report_randomusercourse'));


$table_data = UserCourseTable::getTable();

if ($table_data) {
    echo html_writer::table($table_data);
} else {
    echo get_string('no_data', 'report_randomusercourse');
}

echo $OUTPUT->footer();
