<?php
/**
 * Database configuration
 * Defining the variables
 */

define('USER_CREATED_SUCCESSFULLY', 0);
define('USER_CREATE_FAILED', 1);
define('USER_ALREADY_EXISTED', 2);
define('DEVICE_REGISTRATION_FAILED', 1);

define('TIMEZONE', 'Asia/Kolkata');

/** Mongodb DB Variables **/

define('DATABASE_NAME', 'In-Tuition');
define('DATABASE_SERVER', 'localhost');
define('DATABASE_USERNAME', '');
define('DATABASE_PASSWORD', '');
define('DATABASE_PORT', '27017');

/** Mongodb collections **/
define('COLLECTION_AUTH', 'Authorization');
//define('COLLECTION_EMAIL_AUTH', 'EmailAuth');
define('COLLECTION_USER', 'Users');


/** DEFINE THE RESPONSE CODE**/
define('RETURN_CODE_CONTINUE', '100');   //Continue
define('RETURN_CODE_OK', '200');         // ok
define('RETURN_CODE_CREATED', '201');    // Created
define('RETURN_CODE_ACCEPTED', '202');   // Accepted
define('RETURN_CODE_NO_CONTENT', '204'); // No Content
define('RETURN_CODE_BAD_REQUEST', '400'); // Bad Request
define('RETURN_CODE_UNAUTHORIZED', '401'); // Unauthorized
define('RETURN_CODE_FORBIDDEN', '403'); // Forbidden
define('RETURN_CODE_NOT_FOUND', '404'); // Not Found


define('MY_SECRET_KEY', 'K8ri9x3/mOx12psPHgRz+o9dTKeVhkE0ljd/q8o4I1AyU472t0suM381jDy/nWW7g2gBmyjv5DbaVAHQyYm/7A=='); // My secret key
define('JWT_ALGORITHM', 'HS256');
define('SERVER_NAME', 'in-tuition.com');
