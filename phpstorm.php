<?php
die('This file is used for development purposes only.');
/**
 * PhpStorm Code Completion to CodeIgniter + HMVC
 *
 * @package       CodeIgniter
 * @subpackage    PhpStorm
 * @category      Code Completion
 * @version       3.1.4
 * @author        Shipu Ahamed
 * @link          http://github.com/shipu/codeigniter-phpstorm
 */

/*
 * To enable code completion to your own libraries add a line above each class as follows:
 *
 * @property Library_name       $library_name                        Library description
 *
 */

/**
 * @property CI_Benchmark        $benchmark                           This class enables you to mark points and calculate the time difference between them. Memory consumption can also be displayed.
 * @property CI_Calendar         $calendar                            This class enables the creation of calendars
 * @property CI_Cache            $cache                               Caching Class
 * @property CI_Cart             $cart                                Shopping Cart Class
 * @property CI_Config           $config                              This class contains functions that enable config files to be managed
 * @property CI_Controller       $controller                          This class object is the super class that every library in CodeIgniter will be assigned to
 * @property CI_DB_forge         $dbforge                             Database Forge Class
 * @property CI_DB_mysql_driver|CI_DB_query_builder $db                                  This is the platform-independent base Query Builder implementation class
 * @property CI_DB_utility       $dbutil                              Database Utility Class
 * @property CI_Driver_Library   $driver                              Driver Library Class
 * @property CI_Email            $email                               Permits email to be sent using Mail, Sendmail, or SMTP
 * @property CI_Encrypt          $encrypt                             Provides two-way keyed encoding using Mcrypt
 * @property CI_Encryption       $encryption                          Provides two-way keyed encryption via PHP's MCrypt and/or OpenSSL extensions
 * @property CI_Exceptions       $exceptions                          Exceptions Class
 * @property CI_Form_validation  $form_validation                     Form Validation Class
 * @property CI_FTP              $ftp                                 FTP Class
 * @property CI_Hooks            $hooks                               Provides a mechanism to extend the base system without hacking
 * @property CI_Image_lib        $image_lib                           Image Manipulation class
 * @property CI_Input            $input                               Pre-processes global input data for security
 * @property CI_Javascript       $javascript                          Javascript Class
 * @property CI_Jquery           $jquery                              Jquery Class
 * @property CI_Lang             $lang                                Language Class
 * @property CI_Loader           $load                                Loads framework components
 * @property CI_Log              $log                                 Logging Class
 * @property CI_Migration        $migration                           All migrations should implement this, forces up() and down() and gives access to the CI super-global
 * @property CI_Model            $model                               CodeIgniter Model Class
 * @property CI_Output           $output                              Responsible for sending final output to the browser
 * @property CI_Pagination       $pagination                          Pagination Class
 * @property CI_Parser           $parser                              Parser Class
 * @property CI_Profiler         $profiler                            This class enables you to display benchmark, query, and other data in order to help with debugging and optimization.
 * @property CI_Router           $router                              Parses URIs and determines routing
 * @property CI_Security         $security                            Security Class
 * @property CI_Session          $session                             Session Class
 * @property CI_Table            $table                               Lets you create tables manually or from database result objects, or arrays
 * @property CI_Trackback        $trackback                           Trackback Sending/Receiving Class
 * @property CI_Typography       $typography                          Typography Class
 * @property CI_Unit_test        $unit                                Simple testing class
 * @property CI_Upload           $upload                              File Uploading Class
 * @property CI_URI              $uri                                 Parses URIs and determines routing
 * @property CI_User_agent       $agent                               Identifies the platform, browser, robot, or mobile device of the browsing agent
 * @property CI_Xmlrpc           $xmlrpc                              XML-RPC request handler class
 * @property CI_Xmlrpcs          $xmlrpcs                             XML-RPC server class
 * @property CI_Zip              $zip                                 Zip Compression Class
 * @property CI_Utf8             $utf8                                Provides support for UTF-8 environments
 * @property Ispconfig           $ispconfig                           This class enables you to use the ISPConfig 3 Remote API
 *
 * @property Alert_m             $alert_m                             Alert Model
 * @property Assignment_m        $assignment_m                        Assignment Model
 * @property Assignmentanswer_m  $assignmentanswer_m                  Assignmentanswer Model
 * @property Student_m           $student_m                           Student Model
 * @property Subject_m           $subject_m                           Subject Model
 * @property Schoolyear_m        $schoolyear_m                        School Year Model
 * @property Studentshift_m      $studentshift_m                      Student Shift  Model
 * @property Examschedule_m      $examschedule_m                      Exam Schedule Model
 * @property Mark_m              $mark_m                              Mark  Model
 * @property Grade_m             $grade_m                             Grade  Model
* @property Online_exam_question_m $online_exam_question_m           Online Exam Question  Model
 * @property Classes_m           $classes_m                           Classes  Model
 * @property Question_option_m   $question_option_m                   Question Option  Model
 * @property Online_exam_m       $online_exam_m                       Online Exam  Model
 * @property Studentgroup_m      $studentgroup_m                      Student Group  Model
 * @property Exam_type_m         $exam_type_m                         Exam Type  Model
 * @property Instruction_m       $instruction_m                       Instruction_m  Model
 * @property Question_answer_m   $question_answer_m                   Question Answer  Model
 * @property Markpercentage_m    $markpercentage_m                    Markpercentage  Model
 * @property Markrelation_m      $markrelation_m                      Markrelation  Model
 * @property Setting_m           $setting_m                           setting  Model
 * @property Parents_m           $parents_m                           Parents  Model
 * @property Section_m           $section_m                           Section  Model
 * @property Exam_m              $exam_m                              Exam  Model
 * @property Book_m              $book_m                              Book  Model
 * @property Question            $question                            Question Model
 * @property Question_group_m    $question_group_m                    Question Group  Model
 * @property Question_bank_m     $question_bank_m                     Question Bank  Model
 * @property Question_level_m    $question_level_m                    Question level  Model
 * @property Studentextend_m     $studentextend_m                     Studentextend  Model
 * @property Sattendance_m       $sattendance_m                       Student Attendance Model
 * @property Markdistribution_m  $markdistribution_m                  Markdistribution  Model
 * @property Markdistributioncategory_m      $markdistributioncategory_m                      Markdistributioncategory  Model
 * @property Online_exam_user_status_m              $online_exam_user_status_m
 * @property Online_exam_user_answer_option_m       $online_exam_user_answer_option_m
 * @property Online_exam_user_answer_m              $online_exam_user_answer_m
 *
 */
class CI_Controller {

    public function __construct()
    {
    }
}

/**
 * @property CI_Benchmark        $benchmark                           This class enables you to mark points and calculate the time difference between them. Memory consumption can also be displayed.
 * @property CI_Calendar         $calendar                            This class enables the creation of calendars
 * @property CI_Cache            $cache                               Caching Class
 * @property CI_Cart             $cart                                Shopping Cart Class
 * @property CI_Config           $config                              This class contains functions that enable config files to be managed
 * @property CI_Controller       $controller                          This class object is the super class that every library in CodeIgniter will be assigned to
 * @property CI_DB_forge         $dbforge                             Database Forge Class
 * @property CI_DB_mysql_driver|CI_DB_query_builder $db                                  This is the platform-independent base Query Builder implementation class
 * @property CI_DB_utility       $dbutil                              Database Utility Class
 * @property CI_Driver_Library   $driver                              Driver Library Class
 * @property CI_Email            $email                               Permits email to be sent using Mail, Sendmail, or SMTP
 * @property CI_Encrypt          $encrypt                             Provides two-way keyed encoding using Mcrypt
 * @property CI_Encryption       $encryption                          Provides two-way keyed encryption via PHP's MCrypt and/or OpenSSL extensions
 * @property CI_Exceptions       $exceptions                          Exceptions Class
 * @property CI_Form_validation  $form_validation                     Form Validation Class
 * @property CI_FTP              $ftp                                 FTP Class
 * @property CI_Hooks            $hooks                               Provides a mechanism to extend the base system without hacking
 * @property CI_Image_lib        $image_lib                           Image Manipulation class
 * @property CI_Input            $input                               Pre-processes global input data for security
 * @property CI_Javascript       $javascript                          Javascript Class
 * @property CI_Jquery           $jquery                              Jquery Class
 * @property CI_Lang             $lang                                Language Class
 * @property CI_Loader           $load                                Loads framework components
 * @property CI_Log              $log                                 Logging Class
 * @property CI_Migration        $migration                           All migrations should implement this, forces up() and down() and gives access to the CI super-global
 * @property CI_Model            $model                               CodeIgniter Model Class
 * @property CI_Output           $output                              Responsible for sending final output to the browser
 * @property CI_Pagination       $pagination                          Pagination Class
 * @property CI_Parser           $parser                              Parser Class
 * @property CI_Profiler         $profiler                            This class enables you to display benchmark, query, and other data in order to help with debugging and optimization.
 * @property CI_Router           $router                              Parses URIs and determines routing
 * @property CI_Security         $security                            Security Class
 * @property CI_Session          $session                             Session Class
 * @property CI_Table            $table                               Lets you create tables manually or from database result objects, or arrays
 * @property CI_Trackback        $trackback                           Trackback Sending/Receiving Class
 * @property CI_Typography       $typography                          Typography Class
 * @property CI_Unit_test        $unit                                Simple testing class
 * @property CI_Upload           $upload                              File Uploading Class
 * @property CI_URI              $uri                                 Parses URIs and determines routing
 * @property CI_User_agent       $agent                               Identifies the platform, browser, robot, or mobile device of the browsing agent
 * @property CI_Xmlrpc           $xmlrpc                              XML-RPC request handler class
 * @property CI_Xmlrpcs          $xmlrpcs                             XML-RPC server class
 * @property CI_Zip              $zip                                 Zip Compression Class
 * @property CI_Utf8             $utf8                                Provides support for UTF-8 environments
 */
class CI_Model {

    public function __construct()
    {
    }
}

/**
 * @property CI_Benchmark        $benchmark                           This class enables you to mark points and calculate the time difference between them. Memory consumption can also be displayed.
 * @property CI_Calendar         $calendar                            This class enables the creation of calendars
 * @property CI_Cache            $cache                               Caching Class
 * @property CI_Cart             $cart                                Shopping Cart Class
 * @property CI_Config           $config                              This class contains functions that enable config files to be managed
 * @property CI_Controller       $controller                          This class object is the super class that every library in CodeIgniter will be assigned to
 * @property CI_DB_forge         $dbforge                             Database Forge Class
 * @property CI_DB_mysql_driver|CI_DB_query_builder $db                                  This is the platform-independent base Query Builder implementation class
 * @property CI_DB_utility       $dbutil                              Database Utility Class
 * @property CI_Driver_Library   $driver                              Driver Library Class
 * @property CI_Email            $email                               Permits email to be sent using Mail, Sendmail, or SMTP
 * @property CI_Encrypt          $encrypt                             Provides two-way keyed encoding using Mcrypt
 * @property CI_Encryption       $encryption                          Provides two-way keyed encryption via PHP's MCrypt and/or OpenSSL extensions
 * @property CI_Exceptions       $exceptions                          Exceptions Class
 * @property CI_Form_validation  $form_validation                     Form Validation Class
 * @property CI_FTP              $ftp                                 FTP Class
 * @property CI_Hooks            $hooks                               Provides a mechanism to extend the base system without hacking
 * @property CI_Image_lib        $image_lib                           Image Manipulation class
 * @property CI_Input            $input                               Pre-processes global input data for security
 * @property CI_Javascript       $javascript                          Javascript Class
 * @property CI_Jquery           $jquery                              Jquery Class
 * @property CI_Lang             $lang                                Language Class
 * @property CI_Loader           $load                                Loads framework components
 * @property CI_Log              $log                                 Logging Class
 * @property CI_Migration        $migration                           All migrations should implement this, forces up() and down() and gives access to the CI super-global
 * @property CI_Model            $model                               CodeIgniter Model Class
 * @property CI_Output           $output                              Responsible for sending final output to the browser
 * @property CI_Pagination       $pagination                          Pagination Class
 * @property CI_Parser           $parser                              Parser Class
 * @property CI_Profiler         $profiler                            This class enables you to display benchmark, query, and other data in order to help with debugging and optimization.
 * @property CI_Router           $router                              Parses URIs and determines routing
 * @property CI_Security         $security                            Security Class
 * @property CI_Session          $session                             Session Class
 * @property CI_Table            $table                               Lets you create tables manually or from database result objects, or arrays
 * @property CI_Trackback        $trackback                           Trackback Sending/Receiving Class
 * @property CI_Typography       $typography                          Typography Class
 * @property CI_Unit_test        $unit                                Simple testing class
 * @property CI_Upload           $upload                              File Uploading Class
 * @property CI_URI              $uri                                 Parses URIs and determines routing
 * @property CI_User_agent       $agent                               Identifies the platform, browser, robot, or mobile device of the browsing agent
 * @property CI_Xmlrpc           $xmlrpc                              XML-RPC request handler class
 * @property CI_Xmlrpcs          $xmlrpcs                             XML-RPC server class
 * @property CI_Zip              $zip                                 Zip Compression Class
 * @property CI_Utf8             $utf8                                Provides support for UTF-8 environments
 */
class MX_Controller {

    public function __construct()
    {
    }
}
