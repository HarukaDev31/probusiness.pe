<?php
//developer
error_reporting(-1);
ini_set('display_errors', 1);


//production
/*
ini_set('display_errors', 0);
if (version_compare(PHP_VERSION, '5.3', '>='))
{
  error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
}
else
{
  error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
}
*/

/*
The 'curl' that this uses comes from
https://github.com/moodlehq/sample-ws-clients/blob/master/PHP-REST/curl.php .
*/


/* If true, the program displays each
   XML response returned by calling Moodle.
*/
define( "TRACING", true );


/* Returns a structure defining
   a test user whose name, password, etc. end
   in $n.
*/
function make_test_user( $n ) 
{
  $user = new stdClass();
  $user->username = 'testusername' . $n;
  $user->password = 'testpassword' . $n;
  $user->firstname = 'testfirstname' . $n;
  $user->lastname = 'testlastname' . $n;
  $user->email = 'testemail' . $n . '@moodle.com';
  $user->auth = 'manual';
  $user->idnumber = 'testidnumber' . $n;
  $user->lang = 'en';
  $user->theme = 'standard';
  $user->timezone = '0';
  $user->mailformat = 0;
  $user->description = 'Hello World!';
  $user->city = 'testcity' . $n;
  $user->country = 'uk';
  return $user;
}


/* Returns a structure defining
   a test course whose name etc. end
   in $n.

   I have set the category ID to 1.
   This works, but is almost certainly wrong.
   I need to find out what it should be.
*/
function make_test_course( $n ) 
{
  $course = new stdClass();
  $course->fullname = 'testcourse' . $n;
  $course->shortname = 'testcourse' . $n;
  $course->categoryid = 1;
  return $course;
}


/* Creates a user from a
   structure defining a user. If the
   creation succeeds, returns the 
   ID for this user. If not, throws
   an exception whose text is the XML
   returned by Moodle.
*/
function create_user( $user, $token )
{
  $users = array( $user );
  $params = array( 'users' => $users );

  $response = call_moodle( 'core_user_create_users', $params, $token );

  if ( xmlresponse_is_exception( $response ) )
    throw new Exception( $response );
  else {
    $user_id = xmlresponse_to_id( $response );
    return $user_id;
  }
}


/* Returns a user data structure containing Moodle's
   data for $user_id. It generates this by
   parsing the XML that Moodle returns. If Moodle
   thinks there is no such user, returns NULL.
*/
function get_user( $user_id, $token )
{
  $userids = array( $user_id );
  $params = array( 'userids' => $userids );

  $response = call_moodle( 'core_user_get_users_by_id', $params, $token );

  $user = xmlresponse_to_user( $response );

  if ( array_key_exists( 'id', $user ) )
    return $user;
  else
    return NULL;
  // If there is no user with this ID, Moodle
  // returns the same enclosing XML as if there were, but 
  // with no values for ID and the other fields. My
  // XML-parsing code therefore creates an object
  // with no fields, which the conditional above
  // detects.
}


/* Deletes the user with ID $user_id. 
   If the delete fails, throws
   an exception whose text is the XML
   returned by Moodle.
*/
function delete_user( $user_id, $token )
{
  $userids = array( $user_id );
  $params = array( 'userids' => $userids );

  $response = call_moodle( 'core_user_delete_users', $params, $token );

  if ( xmlresponse_is_exception( $response ) )
    throw new Exception( $response );
}


/* Assigns the role with $role_id to the user with $user_id
   in the specified context.

   At the moment, always returns an error. I don't know 
   whether this is a bug in Moodle, or a problem with my
   configuration or user or whatever.
*/
function assign_role( $user_id, $role_id, $context_id, $token )
{
  $assignment = array( 'roleid' => $role_id, 'userid' => $user_id, 'contextid' => $context_id );
  $assignments = array( $assignment );
  $params = array( 'assignments' => $assignments );

  $response = call_moodle( 'core_role_assign_roles', $params, $token );
}


/* Creates a course from a
   structure defining a course. If the
   creation succeeds, returns the 
   ID for this course. If not, throws
   an exception whose text is the XML
   returned by Moodle.
*/
function create_course( $course, $token ) 
{
  $courses = array( $course );
  $params = array( 'courses' => $courses );

  $response = call_moodle( 'core_course_create_courses', $params, $token );

  if ( xmlresponse_is_exception( $response ) )
    throw new Exception( $response );
  else {
    $course_id = xmlresponse_to_id( $response );
    return $course_id;
  }
}


/* Returns a course data structure containing Moodle's
   data for $course_id. It generates this by
   parsing the XML that Moodle returns. If Moodle
   thinks there is no such course, returns NULL.
*/
function get_course( $course_id, $token )
{
  $courseids = array( $course_id );
  $params = array( 'options' => array('ids' => $courseids ) );

  $response = call_moodle( 'core_course_get_courses', $params, $token );

  $course = xmlresponse_to_course( $response );

  if ( array_key_exists( 'id', $course ) )
    return $course;
  else
    return NULL;
  // If there is no user with this ID, Moodle
  // returns the same enclosing XML as if there were, but 
  // with no values for ID and the other fields. My
  // XML-parsing code therefore creates an object
  // with no fields, which the conditional above
  // detects.
}


/* Enrols the user into the course with the specified role.
   Does not yet check for errors.

   I haven't tested this.
*/
function enrol( $user_id, $course_id, $role_id, $token ) 
{
  $enrolment = array( 'roleid' => $role_id, 'userid' => $user_id, 'courseid' => $course_id );
  $enrolments = array( $enrolment );
  $params = array( 'enrolments' => $enrolments );

  $response = call_moodle( 'enrol_manual_enrol_users', $params, $token );
}


/* Returns data about users enrolled in the specified course.

   Not sure what Moodle returns yet, so exactly how
   I should parse it. Does not handle multiple users.
*/
function get_enrolled_users( $course_id, $token ) 
{
  $params = array( 'courseid' => $course_id );

  $response = call_moodle( 'core_enrol_get_enrolled_users', $params, $token );

  $user = xmlresponse_to_user( $response );
  return $user;
}


/* Calls the Moodle at http://ireson-paine.com, invoking the specified
   function on $params. Also takes a token. 
   Returns Moodle's response as a string containing XML.
*/ 
function call_moodle( $function_name, $params, $token )
{
  $domain = 'https://aulavirtualprobusiness.com';

  $serverurl = $domain . '/webservice/rest/server.php'. '?wstoken=' . $token . '&wsfunction='.$function_name;

  require_once( './curl.php' );
  $curl = new curl;
  $restformat = '';
  $response = $curl->post( $serverurl . $restformat, $params );

  if ( TRACING ) 
    echo "Response from $function_name: \n", $response, "\n";

  return $response;
}


/* Given a string containing XML returned
   by a successful user creation or course
   creation, parses it and returns the user or course ID
   as an integer.
   Undefined if the XML does not contain such an ID,
   for example if it's an error response.
*/
function xmlresponse_to_id( $xml_string )
{
  $xml_tree = new SimpleXMLElement( $xml_string );          

  $value = $xml_tree->MULTIPLE->SINGLE->KEY->VALUE;
  $id = intval( sprintf( "%s", $value ) );
  // See discussion on http://php.net/manual/es/book.simplexml.php ,
  // especially the posting for "info at kevinbelanger dot com 20-Jan-2011 05:07".
  // There is a bug in the XML parser whereby it doesn't return the
  // text associated with property [0] of a node. The above
  // posting uses sprintf to force a conversion to string.

  return $id;
}  


/* Given a string containing XML returned
   by a successful call to core_user_get_users_by_id,
   parses it and returns the data as a user
   data structure.
   Undefined if the XML does not contain such an ID,
   for example if it's an error response.

   Does not yet handle fields with multiple values.
   I think these are customfields, preferences,
   and enrolledcourses.
*/
function xmlresponse_to_user( $xml_string )
{
  return xmlresponse_parse_names_and_values( $xml_string );
}


/* Given a string containing XML returned
   by a successful call to core_course_get_courses,
   parses it and returns the data as a course
   data structure.
   Undefined if the XML does not contain such an ID,
   for example if it's an error response.

   Does not yet handle fields with multiple values.
*/
function xmlresponse_to_course( $xml_string )
{
  return xmlresponse_parse_names_and_values( $xml_string );
}


/* This parses a string containing the XML returned by
   functions such as core_course_get_courses,
   core_user_get_users_by_id, or core_enrol_get_enrolled_users.
   These strings contain name-value pairs encoded thus:
     <RESPONSE>
     <MULTIPLE>
     <SINGLE>
     <KEY name="id"><VALUE>169</VALUE>
     </KEY>
     <KEY name="username"><VALUE>testusername32</VALUE>
     </KEY>
     </SINGLE>
     </MULTIPLE>
     </RESPONSE>
   The function returns an object with the corresponding
   keys and values.

   Does not yet convert strings to integers where they
   ought to be converted.
*/
function xmlresponse_parse_names_and_values( $xml_string )
{
  $xml_tree = new SimpleXMLElement( $xml_string ); 

  $struct = new StdClass();

  foreach ( $xml_tree->MULTIPLE->SINGLE->KEY as $key ) {
    $name = $key['name'];
    $value = (string)$key->VALUE;
    $struct->$name = $value;
  }

  return $struct;
}


/* True if $xml_string's top-level is
   <EXCEPTION>. I use this to check for error
   responses from Moodle.
*/
function xmlresponse_is_exception( $xml_string )
{
  $xml_tree = new SimpleXMLElement( $xml_string );          

  $is_exception = $xml_tree->getName() == 'EXCEPTION';
  return $is_exception;
}  


/* These are some role IDs from our Moodle,
   obtained by querying the database with
   the command
     select * from mdl_role;
   Hopefully, Moodle won't change them.
   There are a few other roles, but not ones
   I think we need.
*/
define( "MANAGER_ROLE_ID", 1 );
define( "COURSE_CREATOR_ROLE_ID", 2 );
define( "TEACHER_ROLE_ID", 3 );
define( "NON_EDITING_TEACHER_ROLE_ID", 4 );
define( "STUDENT_ROLE_ID", 5 );
define( "GUEST_ROLE_ID", 6 );
define( "AUTHENTICATED_USER_ROLE_ID", 7 );
define( "AUTHENTICATED_USER_ON_FRONTPAGE_ROLE_ID", 8 );


/* These are some context IDs from our Moodle,
   obtained by querying the database with
   the command
     select * from mdl_context;
   and by reading http://moodle.org/mod/forum/discuss.php?d=60125 ,
   "Roles and contexts in Moodle 1.7".
   Hopefully, Moodle won't change them.
   There are other contexts, but not ones
   I think we need.
*/
define( "SYSTEM_CONTEXT_ID", 1 );


function demo()
{
  try {
    echo "Demo of Moodle Web services\n<br>";
    echo "===========================\n<br>";

    //$token = 'b259e3493d64dedde681ba33bf1bba7d';
    $token = '2a41772b01afcf26da875fc1ab59bf45';
    echo "<br>\nUses this token which I created manually: " . $token . "\n<br>"; 

    echo "<br>\nWill now create two users from the following data:\n<br>";
    $user_suffix = 900;
    $user_data_1 = make_test_user( $user_suffix );
    echo "<pre>";
    var_dump( $user_data_1 );
    echo "</pre>";
    echo "<br>\n";
    
    echo "<br>\nWill now get the course details using that ID:\n<br>";
    $course_data_from_moodle = get_course( 1, $token );
    echo "<br>\nCourse details:\n<br>";
    echo "<pre>";
    var_dump( $course_data_from_moodle );
    echo "</pre>";

    /*
    echo "Demo of Moodle Web services\n";
    echo "===========================\n";

    $token = '9_anchovy_and_walnut_flan_4a54';
    echo "\nUses this token which I created manually: " . $token . "\n"; 

    echo "\nWill now create two users from the following data:\n";
    $user_suffix = 38;
    $user_data_1 = make_test_user( $user_suffix );
    print_r( $user_data_1 );
    echo "\n";

    $user_data_2 = make_test_user( $user_suffix+1 );
    print_r( $user_data_2 ); 
    echo "\n";

    $user_id_1 = create_user( $user_data_1, $token );
    if ( is_null( get_user( $user_id_1, $token ) ) )
      echo "\nUser 1 doesn't seem to have been created\n";
    else
      echo "\nUser 1's ID = " . $user_id_1 . "\n";

    $user_id_2 = create_user( $user_data_2, $token );
    if ( is_null( get_user( $user_id_2, $token ) ) )
      echo "\nUser 2 doesn't seem to have been created\n";
    else
      echo "\nUser 2's ID = " . $user_id_2 . "\n";

    echo "\nWill now assign a role to make user 1 a student:\n";
    
    assign_role( $user_id_1, STUDENT_ROLE_ID, SYSTEM_CONTEXT_ID, $token );

    echo "\nWill now get the user details using user 1's ID:\n";
    $user_data_from_moodle_1 = get_user( $user_id_1, $token );
    echo "\nUser details:\n";
    print_r( $user_data_from_moodle_1 );

    echo "\nFor comparison, will now get details for a non-existent user:\n";
    $user_data_from_moodle_3 = get_user( 9999, $token );
    echo "\nUser details:\n";
    print_r( $user_data_from_moodle_3 );

    echo "\nWill now create a course from the following data:\n";
    $course_suffix = 127;
    $course_data = make_test_course( $course_suffix );
    print_r( $course_data ); 
    echo "\n";

    $course_id = create_course( $course_data, $token );
    if ( is_null( get_course( $course_id, $token ) ) )
      echo "\nCourse doesn't seem to have been created\n";
    else
      echo "\nCourse ID = " . $course_id . "\n";

    echo "\nWill now get the course details using that ID:\n";
    $course_data_from_moodle = get_course( $course_id, $token );
    echo "\nCourse details:\n";
    print_r( $course_data_from_moodle );

    echo "\nFor comparison, will now get details for a non-existent course:\n";
    $course_data_from_moodle_3 = get_course( 9999, $token );
    echo "\nCourse details:\n";
    print_r( $course_data_from_moodle_3 );

    echo "\nWill now enrol users 1 and 2:\n";
    $role_id = STUDENT_ROLE_ID;
    enrol( $user_id_1, $course_id, $role_id, $token );
    enrol( $user_id_2, $course_id, $role_id, $token );

    echo "\nWill now get the IDs of who Moodle thinks is enrolled:\n";
    $users_in_course = get_enrolled_users( $course_id, $token );
    echo "\nUser details:\n";
    print_r( $users_in_course );

    echo "\nWill now delete the users:\n";
    delete_user( $user_id_1, $token );
    if ( ! is_null( get_user( $user_id_1, $token ) ) )
      echo "\nUser 1 doesn't seem to have been deleted\n";
    else
      echo "\nUser 1 deleted\n";

    delete_user( $user_id_2, $token );
    if ( ! is_null( get_user( $user_id_2, $token ) ) )
      echo "\nUser 2 doesn't seem to have been deleted\n";
    else
      echo "\nUser 2 deleted\n";
    */
  } 
  catch ( Exception $e ) {
    echo "\nCaught exception:\n" .  $e->getMessage() . "\n";
  }
}


demo();
?>