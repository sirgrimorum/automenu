<?php

/**
 *      "[Menu Item]" => [
 *              "logedin" => true,
 *              "items" =>"__route__sirgrimorum_modelos::index,{'localecode':'__getLocale__','modelo':'article'}__",
 *      ],
 *      "[Menu Item]" => [
 *              "logedin" => false,
 *              "items" =>"__route__home",
 *      ],
 *      "[Menu Item1]" => "__url__users/create",
 *      "[Menu Item2]" => [
 *              "logedin" => function(){
 *                  return Auth::id()==2;
 *              },
 *              "items" =>"relative/url",
 *      ],
 *      "[Menu Item3]" => [
 *              "logedin" => function(){
 *                      return (Gate::allows('update-post',request()->input('id')) || Auth::user()->can('update',Post::class));
 *              },
 *              "items" => "/"
 *      ],
 *      "[Menu Item4]" => [
 *              "logedin" => "NA",
 *              "items"=>[
 *                  "[SubMenu Item]" => "__route__welcome",
 *                  "[SubMenu Item1]"=>[
 *                      "logedin" => true,
 *                      "item" => "http://absolute/url",
 *                  ],
 *                  "-"=>"-",
 *                  "[SubMenu Item2]"=>[
 *                      "logedin" => function(){
 *                          return Auth::check();
 *                      },
 *                      "item" => "blade:modelos.create",
 *                  ],
 *              ],
 *      ],
 *      'text' => [
 *          'logedin' => true,
 *          'item' => 'Algo para poner'
 *      ],
 */

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

return [
    'brand_text' => "SirGrimorum",
    'brand_img' => "__asset__img/logonaranja.png",
    'brand_url' => "__url__/",
    'brand_center' => false,
    'izquierdo' => [
        "Menu Item" => [
            "logedin" => true,
            "items" => "__route__sirgrimorum_home,{'localecode':'__getLocale__'}__",
        ],
        "Menu Item0" => [
            "logedin" => false,
            "items" => "__route__home",
        ],
        "Menu Item1" => "__route__chat.home",
        "Menu Item2" => [
            "logedin" => function() {
                return Auth::id() == 1;
            },
            "items" => "__route__sirgrimorum_modelos::index,{'localecode':'__getLocale__','modelo':'article'}__",
        ],
        "Menu Item3" => [
            "logedin" => function() {
                $user = User::find(Auth::id());
                return $user->can('update', Sirgrimorum\TransArticles\Models\Article::class);
            },
            "items" => "/"
        ],
        "Menu Item4" => [
            "logedin" => true,
            "items" => [
                "SubMenu Item" => "__route__welcome",
                "SubMenu Item1" => [
                    "logedin" => false,
                    "item" => "http://absolute/url",
                ],
                "-" => "-",
                "SubMenu Item2" => [
                    "logedin" => function() {
                        return Auth::check();
                    },
                    "item" => "blade:menuform",
                ],
                'text' => [
                    'logedin' => true,
                    'item' => 'Algo para poner'
                ],
            ],
        ],
    ],
    'derecho' => [
        'buscar' => [
            'logedin' => true,
            'items' => 'blade:menuform'
        ],
        "__trans__crudgenerator::admin.layout.labels." . App::getLocale() => [
            'logedin' => 'NA',
            'items' => [
                'Español' => url('/') . '/es',
                'English' => url('/') . '/en'
            ],
        ]
    ]
];

