<?php
/**
 * Class UserCourseTable
 *
 * The UserCourseTable class retrieves data for a table that displays the username and courses of random users.
 */
final class UserCourseTable {

    /**
     * Returns a HTML table object representing the data from the getTableData method.
     *
     * @return html_table|null A HTML table object representing the data, or null if there is no data.
     */
    public static function getTable(): html_table | null {

        $data = self::getTableData();

        if (empty($data)) {
            return null;
        }

        $table = new html_table();
        $table->head = array(get_string('user_column', 'report_randomusercourse'), get_string('courses_column', 'report_randomusercourse'));
        $table->data = $data;

        return $table;

    }

    /**
     * Retrieves an array of data representing a table.
     * This method selects 10 random users from the database and fetches their username and courses.
     * The data is returned as an associative array, with each entry containing the username and courses of a user.
     *
     * @return array An array of data representing a table.
     */
    private static function getTableData(): array {
        global $DB;
        $random_users = $DB->get_records_sql("SELECT id, username FROM {user} WHERE username != 'guest' ORDER BY RAND() LIMIT 10");
        $data = array();

        foreach ($random_users as $user) {
            $data[] = array('<a href="/course/view.php?id=' . $user->id . '">' . $user->username . '</a>', self::getUserCourses($user->id));
        }

        return $data;
    }

    /**
     * Returns a string representing the courses enrolled by a user.
     *
     * @param int $user_id The ID of the user.
     * @return string The courses enrolled by the user as a string separated by commas, or 'No courses' if the user has no enrolled courses.
     */
    private static function getUserCourses($user_id): string {
        global $DB;

        $courses = array();

        $enrolled_courses = $DB->get_records_sql(
            "SELECT c.id, c.fullname
             FROM {course} c
             JOIN {enrol} e ON c.id = e.courseid
             JOIN {user_enrolments} ue ON e.id = ue.enrolid
             WHERE ue.userid = :userid",
            array('userid' => $user_id)
        );

         foreach ($enrolled_courses as $course) {
            $courses[] = '<a href="/course/view.php?id=' . $course->id . '">' . $course->fullname . '</a>';
        }

         if (empty($courses)) {
             return 'No courses';
         }

         return implode(', ', $courses);
    }
}