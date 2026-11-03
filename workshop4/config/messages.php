<?php

// Textos de los mensajes que se muestran con ?error= o ?success= en la URL
return [
    'error' => [
        'invalid_input' => 'Please fill in all the required fields correctly.',
        'invalid_credentials' => 'Invalid username or password.',
        'login_required' => 'You must log in to access that page.',
        'session_expired' => 'Your session expired. Please log in again.',
        'password_too_short' => 'The password must be at least 8 characters long.',
        'password_mismatch' => 'The passwords do not match.',
        'invalid_province' => 'Please select a valid province.',
        'username_taken' => 'That username is already taken.',
        'wrong_password' => 'The current password is incorrect.',
        'invalid_picture' => 'The profile picture must be a JPG, PNG, GIF or WEBP image.',
        'picture_too_large' => 'The profile picture must be 2 MB or smaller.',
        'upload_failed' => 'The profile picture could not be uploaded. Please try again.',
        'server_error' => 'Something went wrong. Please try again later.',
        'invalid_course_input' => 'Please fill in all the required course fields correctly.',
        'invalid_career' => 'Please select a valid career.',
        'course_code_taken' => 'That course code is already in use.',
        'course_not_found' => 'The requested course could not be found.',
    ],
    'success' => [
        'registered' => 'Your account was created. You can now log in.',
        'logged_out' => 'You have been logged out.',
        'updated' => 'Your profile was updated.',
        'course_created' => 'The course was created.',
        'course_updated' => 'The course was updated.',
        'course_deleted' => 'The course was deleted.',
    ],
];
