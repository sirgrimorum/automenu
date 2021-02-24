<?php

return[
    "menu_stack" => "", //Name of a new blade stack before the navbar item
    "menuitem_izquierda_stack" => "menuobjizq", //Name of a new blade stack inside the left navbar-nav before the automenu items
    "menuitem_derecha_stack" => "menuobjder", //Name of a new blade stack inside the right navbar-nav before the automenu items
    "classes" => [ //extra classes to add to each element of the navbar
        "navbar_extra" => "navbar-dark bg-dark sticky-top",
        "navbar_brand" => "",
        "brand_img" => "",
        "brand_img_height" => 30, // default 30
        "navbar_collapse" => "",
        "navbar_nav_izquierdo" => "mr-auto pl-2",
        "navbar_nav_derecho" => "ml-auto pr-2 text-right justify-content-end",
        "item_izquierdo" => "",
        "item_izquierdo_primero" => "", // For the first item of the left navbar-nav
        "item_izquierdo_interno" => "", //For every item inside a dropdown in the left navbar-nav
        "item_derecho" => "",
        "item_derecho_primero" => "", // For the first item of the left navbar-nav
        "item_derecho_interno" => "", //For every item inside a dropdown in the left navbar-nav
        "button_izquierdo" => "", //For the centered configuration and the toogle menu button in the normal configuration
        "button_derecho" => "", //For the centered configuration
    ],
    'icons' => [
        'left' => "fa fa-bars", //For the centered configuration and the toogle menu button in the normal configuration
        'right' => "fa fa-user", //For the centered configuration
    ],
    "replaces"=>[ // Strings to be replaced with current user's fields values
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
