<?php

return [

    /*
    |--------------------------------------------------------------------------
    | KYC Fields
    |--------------------------------------------------------------------------
    |
    | These fields will be used for user submission,
    | verification officer review and admin approval.
    |
    */

    'fields' => [

        'pan' => [
            'label' => 'Business PAN',
            'type' => 'text',
            'required' => true,
        ],

        'pan_image' => [
            'label' => 'Business PAN Image',
            'type' => 'file',
            'required' => true,
        ],

        'gst' => [
            'label' => 'GST Number',
            'type' => 'text',
            'required' => false,
        ],

        'owner_aadhar' => [
            'label' => 'Owner Aadhaar Number',
            'type' => 'text',
            'required' => true,
        ],

        'owner_aadhar_image_front' => [
            'label' => 'Owner Aadhaar Front Image',
            'type' => 'file',
            'required' => true,
        ],

        'owner_aadhar_image_back' => [
            'label' => 'Owner Aadhaar Back Image',
            'type' => 'file',
            'required' => true,
        ],

        'owner_pan' => [
            'label' => 'Owner PAN Number',
            'type' => 'text',
            'required' => true,
        ],

        'owner_pan_image' => [
            'label' => 'Owner PAN Image',
            'type' => 'file',
            'required' => true,
        ],

    ],

];
