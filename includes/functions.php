<?php

function validate_user(array $data) {
    $errors = [];
    if (empty($data['name'])) {
        $errors['name'] = 'Name is required';
    }
    if (empty($data['email'])) {
        $errors['email'] = 'Email is required';
    }
    if (isset($data['password']) && empty($data['password'])) {
        $errors['password'] = 'Password is required';
    }

    return $errors;
}

function redirect($url) {
    header("Location: $url");
    exit;
}

function upload($key) {
    $filepath = null;
    if (isset($_FILES[$key]) && $_FILES[$key]['error'] == UPLOAD_ERR_OK) {
        $offset = strrpos($_FILES[$key]['name'], '.');
        $name = uniqid() . substr($_FILES[$key]['name'], -1 * $offset);
        $filepath = __DIR__ . '/../uploads/' . $name;
        move_uploaded_file($_FILES[$key]['tmp_name'], $filepath);
    }
    return $filepath;
}