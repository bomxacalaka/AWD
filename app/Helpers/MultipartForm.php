<?php

function form_open_multipart($form_name, $form_id, $form_options) {
    $form = '<form action="' . base_url($form_name) . '" method="post" enctype="multipart/form-data"';
    if($form_id) {
        $form .= ' id="' . $form_id . '"';
    }
    if($form_options) {
        $form .= ' ' . $form_options;
    }
    $form .= '>';
    return $form;
}
