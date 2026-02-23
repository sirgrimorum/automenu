<?php

namespace Sirgrimorum\AutoMenu;

use App\User;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AutoMenu {

    function __construct() {

    }

    /**
     * Construye el html del menú
     * @param String $id Id para el container del menu
     * @param String/Array $config El nombre del archivo de configuración o el array de configuración con los datos del menú
     * @param String/Array $automenu El nombre del archivo localizado o el array de la estructura del menu
     * @return String Html con el menu
     */
    public static function buildAutoMenu($id = "menu", $config = "", $automenu = "") {
        if (!is_array($config)) {
            if ($config == "") {
                $config = 'sirgrimorum.automenu';
            }
            $config = config($config);
        }
        $config['id'] = $id;
        //$config = AutoMenu::translateConfig($config);
        if (!is_array($automenu)) {
            if ($automenu == "") {
                $automenu = 'automenu::automenu';
            }
            $automenu = trans($automenu);
        }
        $automenu = AutoMenu::translateConfig($automenu);
        $config['menu'] = $automenu;
        $configObj = json_decode(json_encode($config), false);
        //echo "<p>config</p><pre>" . print_r($config, true) . "</pre>";
        //return "hola";
        return view('automenu::menu', [
            "config" => $config,
        ]);
    }

    public static function replaceUser($string, $config = "") {
        if (!is_array($config)) {
            $config = config('sirgrimorum.automenu');
        }
        foreach ($config['replaces'] as $str => $campo) {
            if (Auth::check()) {
                $user = User::find(Auth::id());
                if (is_callable($user->$campo)) {
                    $string = str_replace($str, $user->$campo(), $string);
                } elseif (method_exists(Auth::user(),"get")) {
                    $string = str_replace($str, $user->get($campo), $string);
                } else {
                    $string = str_replace($str, $user->$campo, $string);
                }
            }
        }
        return $string;
    }

    public static function hasAccess($detalles) {
        //echo "<p>evaluando</p><pre>" . print_r($detalles) . "</pre>";
        if ($detalles === true) {
            //echo "<strong>aqui2</strong>";
            $mostrar = Auth::check();
        } elseif ($detalles === false) {
            //echo "<strong>aqui3</strong>";
            $mostrar = !Auth::check();
        } elseif (is_callable($detalles)) {
            //echo "<strong>aqui</strong>";
            $mostrar = (bool) $detalles();
        } elseif (strtolower($detalles) == "na") {
            $mostrar = true;
        } else {
            $mostrar = false;
        }
        if ($mostrar) {
            //echo "Res=si";
        } else {
            //echo "Res=no";
        }
        return $mostrar;
    }

    /**
     *  Evaluate functions inside the config array, such as trans(), route(), url() etc.
     *
     * @param array $array The config array
     * @return array The operated config array
     */
    private static function translateConfig($array) {
        $result = [];
        foreach ($array as $key => $item) {
            $key = str_replace(config("sirgrimorum.automenu.locale_key"), App::getLocale(), $key);
            $key = AutoMenu::translateString($key, config("sirgrimorum.automenu.trans_prefix"), "trans");
            $key = AutoMenu::translateString($key, config("sirgrimorum.automenu.asset_prefix"), "asset");
            $key = AutoMenu::translateString($key, config("sirgrimorum.automenu.public_prefix"), "public_path");
            if (!($item instanceof Closure)) {
                if (is_array($item)) {
                    $result[$key] = AutoMenu::translateConfig($item);
                } elseif (is_string($item)) {
                    $item = str_replace(config("sirgrimorum.automenu.locale_key"), App::getLocale(), $item);
                    $item = AutoMenu::translateString($item, config("sirgrimorum.automenu.route_prefix"), "route");
                    $item = AutoMenu::translateString($item, config("sirgrimorum.automenu.url_prefix"), "url");
                    $item = AutoMenu::translateString($item, config("sirgrimorum.automenu.trans_prefix"), "trans");
                    $item = AutoMenu::translateString($item, config("sirgrimorum.automenu.asset_prefix"), "asset");
                    $item = AutoMenu::translateString($item, config("sirgrimorum.automenu.public_prefix"), "public_path");
                    $result[$key] = $item;
                } else {
                    $result[$key] = $item;
                }
            } else {
                $result[$key] = $item;
            }
        }
        return $result;
    }

    /**
     * Use the crudgenerator prefixes to change strings in config array to evaluate
     * functions such as route(), trans(), url(), etc.
     *
     * For parameters, use ',' to separate them inside the prefix and the close.
     *
     * For array, use json notation inside comas
     *
     * @param string $item The string to operate
     * @param string $prefix The prefix for the function
     * @param string $function The name of the function to evaluate
     * @param string $close Optional, the closing string for the prefix, default is '__'
     * @return string The string with the results of the evaluations
     */
    private static function translateString($item, $prefix, $function, $close = "__") {
        $result = "";
        if (Str::contains($item, $prefix)) {
            if (($left = (stripos($item, $prefix))) !== false) {
                while ($left !== false) {
                    if (($right = stripos($item, $close, $left + strlen($prefix))) === false) {
                        $right = strlen($item);
                    }
                    $textPiece = substr($item, $left + strlen($prefix), $right - ($left + strlen($prefix)));
                    $piece = $textPiece;
                    if (Str::contains($textPiece, "{")) {
                        $auxLeft = (stripos($textPiece, "{"));
                        $auxRight = stripos($textPiece, "}", $left) + 1;
                        $auxJson = substr($textPiece, $auxLeft, $auxRight - $auxLeft);
                        $textPiece = str_replace($auxJson, "*****", $textPiece);
                        $auxJson = str_replace(["'", ", }"], ['"', "}"], $auxJson);
                        $auxArr = explode(",", str_replace([" ,", ", "], [",", ","], $textPiece));
                        if ($auxIndex = array_search("*****", $auxArr)) {
                            $auxArr[$auxIndex] = json_decode($auxJson, true);
                        } else {
                            $auxArr[] = json_decode($auxJson);
                        }
                        $piece = call_user_func_array($function, $auxArr);
                    } else {
                        $piece = call_user_func($function, $textPiece);
                    }
                    if (is_string($piece)) {
                        if ($right <= strlen($item)) {
                            $item = substr($item, 0, $left) . $piece . substr($item, $right + 2);
                        } else {
                            $item = substr($item, 0, $left) . $piece;
                        }
                        $left = (stripos($item, $prefix));
                    } else {
                        $item = $piece;
                        $left = false;
                    }
                }
            }
            $result = $item;
        } else {
            $result = $item;
        }
        return $result;
    }

}
