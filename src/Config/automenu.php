<?php

return[
    "menu_stack" => "",
    "menuitem_izquierda_stack" => "menuobjizq",
    "menuitem_derecha_stack" => "menuobjder",
    "classes" => [
        "navbar_extra" => "navbar-dark bg-dark navbar-fixed-top",
        "navbar_brand" => "",
        "brand_img" => "",
        "navbar_collapse" => "",
        "navbar_nav_izquierdo" => "pl-2",
        "navbar_nav_derecho" => "pr-2 text-right justify-content-end",
        "item_izquierdo" => "",
        "item_derecho" => "",
        "button_izquierdo" => "",
        "button_derecho" => "",
    ],
    'icons' => [
        'left' => "fa fa-bars",
        'right' => "fa fa-user",
    ],
    "replaces"=>[
        "{name}"=>"name",
        "{email}"=>"email",
        "{image}"=>"image",
    ],
    /**
     * asset function prefix for configuration file in order to know is needed to translate with the following key
     */
    'asset_prefix' => '__asset__',
    /**
     * public_path function prefix for configuration file in order to know is needed to translate with the following key
     */
    'public_prefix' => '__public__',
    /**
     * trans function prefix for configuration file in order to know is needed to translate with the following key
     */
    'trans_prefix' => '__trans__',
    /**
     * route function prefix for configuration file in order to know is needed to translate routes with the following key
     */
    'route_prefix' => '__route__',
    /**
     * url function prefix for configuration file in order to know is needed to translate routes with the following key
     */
    'url_prefix' => '__url__',
    /**
     * App::getLocale() key for configuration file in order to know is needed to translate locales with the following key
     */
    'locale_key' => '__getLocale__',
];
