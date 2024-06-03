<?php
//developer
/*
error_reporting(-1);
ini_set('display_errors', 1);
*/

//production

ini_set('display_errors', 0);
if (version_compare(PHP_VERSION, '5.3', '>='))
{
  error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT & ~E_USER_NOTICE & ~E_USER_DEPRECATED);
}
else
{
  error_reporting(E_ALL & ~E_NOTICE & ~E_STRICT & ~E_USER_NOTICE);
}


/*
The 'curl' that this uses comes from
https://github.com/moodlehq/sample-ws-clients/blob/master/PHP-REST/curl.php .
*/


/* If true, the program displays each
   XML response returned by calling Moodle.
*/
define( "TRACING", true );

/*
username string   //Username policy is defined in Moodle security config.
firstname string   //The first name(s) of the user
lastname string   //The family name of the user
email string   //A valid and unique email address
auth string  Valor por defecto para "manual" //Auth plugins include manual, ldap, etc
lang string  Valor por defecto para "es" //Language code such as "en", must exist on server
calendartype string  Valor por defecto para "gregorian" //Calendar type such as "gregorian", must exist on server
*/

/* Returns a structure defining
   a test user whose name, password, etc. end
   in $n.
*/
function make_test_user( $arrPost ){
  $user = new stdClass();
  $user->username = $arrPost['username'];
  $user->password = $arrPost['password'];
  $user->firstname = $arrPost['firstname'];
  $user->lastname = $arrPost['username'];
  $user->email = $arrPost['email'];
  $user->auth = 'manual';
  $user->lang = 'es';
  $user->calendartype = 'gregorian';
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

  if ( xmlresponse_is_exception( $response ) ) {
    //throw new Exception( $response );
    return array(
      'status' => 'error',
      'message' => "Caught exception: " .  $response
    );
  } else {
    $user_id = xmlresponse_to_id( $response );
    //return $user_id;
    return array(
      'status' => 'success',
      'message' => "Creado " .  $user_id
    );
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

function get_user_field( $params, $token )
{
  $response = call_moodle( 'core_user_get_users', $params, $token );

  $user = xmlresponse_to_user_all( $response );
  
  if ( array_key_exists( 'id', $user ) ) {
    return array(
      'status' => 'success',
      'message' => "Existe usuario",
      'response' => $user
    );
  } else {
    return array(
      'status' => 'error',
      'message' => "No existe usuario"
    );
  }
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

  if ( TRACING ) {
    /*
    return array(
      'status' => 'success',
      'message' => "Response from $function_name: \n", $response, "\n"
    );
    */
    //echo "Response from $function_name: \n", $response, "\n";
  }

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


function xmlresponse_to_user_all( $xml_string )
{
  return xmlresponse_parse_names_and_values_all( $xml_string );
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

function xmlresponse_parse_names_and_values_all( $xml_string )
{
  $xml_tree = new SimpleXMLElement( $xml_string ); 
  
  $struct = new StdClass();

  if(!empty($xml_tree->SINGLE->KEY->MULTIPLE->SINGLE->KEY)) {
    foreach ( $xml_tree->SINGLE->KEY->MULTIPLE->SINGLE->KEY as $key ) {
      $name = $key['name'];
      $value = (string)$key->VALUE;
      $struct->$name = $value;
    }
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

function createUser($arrPost){
  try {
    $token = '2a41772b01afcf26da875fc1ab59bf45';
    $user_data_1 = make_test_user( $arrPost );
    $user_id_1 = create_user( $user_data_1, $token );
    return $user_id_1;
  } 
  catch ( Exception $e ) {
    return array(
      'status' => 'error',
      'message' => "Caught exception: " .  $e->getMessage()
    );
    //echo "\nCaught exception:\n" .  $e->getMessage() . "\n";
  }
}

function getUser($arrParams){
  try {
    $token = '2a41772b01afcf26da875fc1ab59bf45';
    $user_id_1 = get_user_field( $arrParams, $token );
    return $user_id_1;
  } 
  catch ( Exception $e ) {
    return array(
      'status' => 'error',
      'message' => "Caught exception: " .  $e->getMessage()
    );
    //echo "\nCaught exception:\n" .  $e->getMessage() . "\n";
  }
}

function crearCursoUsuario($arrParams){
  try {
    $token = '2a41772b01afcf26da875fc1ab59bf45';

    $user_id_1 = $arrParams['id_usuario'];
    $role_id = 5;//usuario invitado

    $course_id = 4;//Módulo 1: Introducción a las importaciones
    $response_xml = enrol( $user_id_1, $course_id, $role_id, $token );
    $response_xml = new SimpleXMLElement( $response_xml );
    
    $course_id = 5;//Módulo 2: Importación Simplificada
    $response_xml = enrol( $user_id_1, $course_id, $role_id, $token );
    $response_xml = new SimpleXMLElement( $response_xml );
    
    $course_id = 6;//Módulo 3: Importación de USA
    $response_xml = enrol( $user_id_1, $course_id, $role_id, $token );
    $response_xml = new SimpleXMLElement( $response_xml );
    
    $course_id = 7;//Módulo 4: Importación Definitiva
    $response_xml = enrol( $user_id_1, $course_id, $role_id, $token );
    $response_xml = new SimpleXMLElement( $response_xml );
    
    $course_id = 10;//Módulo 5: Carga Consolidada
    $response_xml = enrol( $user_id_1, $course_id, $role_id, $token );
    $response_xml = new SimpleXMLElement( $response_xml );
    
    $course_id = 9;//sumen de Módulos
    $response_xml = enrol( $user_id_1, $course_id, $role_id, $token );
    $response_xml = new SimpleXMLElement( $response_xml );

    if(!isset($response_xml->MESSAGE)){
      return array(
        'status' => 'success',
        'message' => "Asignación de cursos exitoso"
      );
    } else {
      return array(
        'status' => 'error',
        'message' => "Problemas: " . $response_xml->MESSAGE
      );
    }
  } 
  catch ( Exception $e ) {
    return array(
      'status' => 'error',
      'message' => "Caught exception: " .  $e->getMessage()
    );
  }
}

//params POST
$arrPost = $_POST;
/*
echo "<pre>";
var_dump($_POST);
echo "</pre>";
*/

if($arrPost['evento'] == 'crear_usuario'){
  /*agregar etiqueta en ESCALA*/
  // Get the authentication token from the environment
  $token = 'sxMYrKuF42RhTcABmidg_2Q9B0vkEdap-T4TwKyKzCD-DSZl1F4Jeun_euLfeTiLPfjYq7a4lSxyovuNe26z0w';

  // Set the request headers
  $headers = array(
    'Content-Type: application/json',
    'x-api-key: ' . $token
  );

  //data params
  $iIdContact = $arrPost['id'];
  $iIdTag = $arrPost['id_etiqueta'];

  // Set the base API URL
  $baseApiUrl = 'https://public-api.escala.com/v1/crm/contacts/' . $iIdContact . '/tags';

  // Initialize a cURL session
  $ch = curl_init($baseApiUrl);

  // Set the request headers
  $postData = array(
    'addTags' => array($iIdTag),
    'triggerWorkflow' => false
  );

  // Set options for the cURL session
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
  curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

  // Execute the cURL session
  $response_etiqueta = curl_exec($ch);
  $statusCode_etiqueta = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  /*fin ESCALA*/

  /* ASIGNAR CURSOS USUARIO */
  //FALTA
  /* FIN ASIGNAR USUARIO */

  $response = createUser($arrPost);
  echo json_encode($response);
} else if($arrPost['evento'] == 'buscar_usuario'){
  $arrParams['criteria'][0]['key']='username';
  $arrParams['criteria'][0]['value']=$arrPost['username'];

  $response = getUser($arrParams);
  echo json_encode($response);
} else if($arrPost['evento'] == 'asignar_curso_usuario'){
  // Property added to the object
  $arrParams['criteria'][0]['key']='username';
  $arrParams['criteria'][0]['value']=$arrPost['username'];
  $response_usuario = getUser($arrParams);
  if($response_usuario['status']=='success'){
    $result = $response_usuario['response'];
    $id_usuario = $result->id;
    $arrParams = array(
      'id_usuario' => $id_usuario//id_usuario
    );
    $response = crearCursoUsuario($arrParams);
    echo json_encode($response);
  } else {
    echo json_encode($response_usuario);
  }
} else {
  return array(
    'status' => 'error',
    'message' => "No existe evento"
  );
}

?>