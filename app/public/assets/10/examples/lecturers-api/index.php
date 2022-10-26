<?php

require_once('../WebApiHelper.php');

$lecturers = [
    1 => ['id' => 1, 'name' => 'Joris Maervoet'],
    2 => ['id' => 2, 'name' => 'Pieter Van Peteghem']
];

$helper = new WebApiHelper();

if ($matches = $helper->matches('GET', 'api/lecturers')) {

    echo json_encode(['lecturers' => array_values($lecturers)]);
    exit();

}
else if ($matches = $helper->matches('GET', 'api/lecturers/([0-9]+)')) {

    $id = $matches[0];
    if (array_key_exists($id, $lecturers)) {
        echo json_encode($lecturers[$id]);
    } else {
        WebApiHelper::message(404, 'Lecturer not found.');
    }
    exit();

} else {

    WebApiHelper::message(404, 'Not found.');
    exit();

}