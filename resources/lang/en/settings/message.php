<?php
/**
* Language file for group error/success messages
*
*/

return array(

    'setting_exists'        => 'Setting already exists!',
    'setting_not_found'     => 'Settings [:id] do not exist.',
    'group_name_required' => 'The name field is required',

    'success' => array(
        'create' => 'Settings were successfully created.',
        'update' => 'Settings were successfully updated.',
        'delete' => 'Settings were successfully deleted.',
    ),

    'delete' => array(
        'create' => 'There was an issue creating the group. Please try again.',
        'update' => 'There was an issue updating the group. Please try again.',
        'delete' => 'There was an issue deleting the group. Please try again.',
    ),

    'error' => array(
        'group_exists' => 'A group already exists with that name, names must be unique for groups.',
        'update' => 'There was an issue updating the group. Please try again.',
    ),
);
