<?php

/*
 * Config file for Flash Messages
 *
 * Icon: Font Awesome (optional)
 * Title: The heading of the flash message (optional)
 * css_class: CSS-class for the flash message (optional),
 * Template: Template file for rendering the flash message.
 *     * default: Template without icon
 *     * with_icon: Template with icon.
*/

return [

    "template" => [
        "default"       => "flasher/default",
        "with_icon"     => "flasher/with-icon"
    ],

    "types" => [

        "success" => [
            "css_class" => "Flash Flash--success",
            "icon"      => "fa-check-circle",
            "title"     => "Success!"
        ],
        "warning" => [
            "css_class" => "Flash Flash--warning",
            "icon"      => "fa-exclamation-circle",
            "title"     => "Warning!"
        ],
        "notice" => [
            "css_class" => "Flash Flash--notice",
            "icon"      => "fa-info",
            "title"     => "Notice."
        ],
        "error" => [
            "css_class" => "Flash Flash--error",
            "icon"      => "fa-flag",
            "title"     => "Error."
        ]
    ]
];
