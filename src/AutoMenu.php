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
        $defaultConfig = config('sirgrimorum.automenu');
        if (!is_array($config)) {
            if ($config == "") {
                $config = $defaultConfig;
            } else {
                $config = config($config);
            }
        }
        if (is_array($config)) {
            $config = array_merge($defaultConfig, $config);
        } else {
            $config = $defaultConfig;
        }
        $config['id'] = $id;
        
        if (!is_array($automenu)) {
            if ($automenu == "") {
                $automenu = 'automenu::automenu';
            }
            $automenu = trans($automenu);
        }
        if (!is_array($automenu)) {
            $automenu = ['top' => [], 'izquierdo' => [], 'derecha' => []];
        }
        
        $automenuTranslated = AutoMenu::translateConfig($automenu);
        
        // Final fallback to ensure the view never crashes
        if (!is_array($automenuTranslated)) {
            $automenuTranslated = ['top' => [], 'izquierdo' => [], 'derecha' => []];
        }
        if (!isset($automenuTranslated['izquierdo'])) {
            $automenuTranslated['izquierdo'] = [];
        }
        if (!isset($automenuTranslated['derecha'])) {
            $automenuTranslated['derecha'] = [];
        }
        if (!isset($automenuTranslated['top'])) {
            $automenuTranslated['top'] = [];
        }
        
        $config['menu'] = $automenuTranslated;
        
        return view('automenu::menu', [
            "config" => $config,
        ]);
    }

    public static function replaceUser($string, $config = "") {
        if (!is_array($config)) {
            $config = config('sirgrimorum.automenu');
        }
        if (isset($config['replaces']) && is_array($config['replaces'])) {
            foreach ($config['replaces'] as $str => $campo) {
                if (Auth::check()) {
                    $user = User::find(Auth::id());
                    if ($user) {
                        if (is_callable($user->$campo)) {
                            $string = str_replace($str, $user->$campo(), $string);
                        } elseif (method_exists($user,"get")) {
                            $string = str_replace($str, $user->get($campo), $string);
                        } else {
                            $string = str_replace($str, $user->$campo, $string);
                        }
                    }
                }
            }
        }
        return $string;
    }

    public static function hasAccess($detalles) {
        if ($detalles === true) {
            return Auth::check();
        } elseif ($detalles === false) {
            return !Auth::check();
        } elseif (is_callable($detalles)) {
            return (bool) $detalles();
        } elseif (is_string($detalles) && strtolower($detalles) == "na") {
            return true;
        } else {
            return false;
        }
    }

    private static function translateConfig($array) {
        if (!is_array($array)) {
            return $array;
        }
        $result = [];
        $locale_key = (string) config("sirgrimorum.automenu.locale_key");
        $trans_prefix = (string) config("sirgrimorum.automenu.trans_prefix");
        $asset_prefix = (string) config("sirgrimorum.automenu.asset_prefix");
        $public_prefix = (string) config("sirgrimorum.automenu.public_prefix");
        $route_prefix = (string) config("sirgrimorum.automenu.route_prefix");
        $url_prefix = (string) config("sirgrimorum.automenu.url_prefix");

        foreach ($array as $key => $item) {
            $newKey = (string) $key;
            if ($locale_key != "") $newKey = str_replace($locale_key, (string) App::getLocale(), $newKey);
            if ($trans_prefix != "") $newKey = AutoMenu::translateString($newKey, $trans_prefix, "trans");
            if ($asset_prefix != "") $newKey = AutoMenu::translateString($newKey, $asset_prefix, "asset");
            if ($public_prefix != "") $newKey = AutoMenu::translateString($newKey, $public_prefix, "public_path");
            
            if ($item instanceof Closure) {
                $result[$newKey] = $item;
            } elseif (is_array($item)) {
                $result[$newKey] = AutoMenu::translateConfig($item);
            } elseif (is_string($item)) {
                $newItem = $item;
                if ($locale_key != "") $newItem = str_replace($locale_key, (string) App::getLocale(), $newItem);
                if ($route_prefix != "") $newItem = AutoMenu::translateString($newItem, $route_prefix, "route");
                if ($url_prefix != "") $newItem = AutoMenu::translateString($newItem, $url_prefix, "url");
                if ($trans_prefix != "") $newItem = AutoMenu::translateString($newItem, $trans_prefix, "trans");
                if ($asset_prefix != "") $newItem = AutoMenu::translateString($newItem, $asset_prefix, "asset");
                if ($public_prefix != "") $newItem = AutoMenu::translateString($newItem, $public_prefix, "public_path");
                $result[$newKey] = $newItem;
            } else {
                $result[$newKey] = $item;
            }
        }
        return $result;
    }

    private static function translateString($item, $prefix, $function, $close = "__") {
        if ($prefix == "" || !is_string($item) || !Str::contains($item, $prefix)) {
            return $item;
        }
        
        $left = stripos($item, $prefix);
        while ($left !== false) {
            $right = stripos($item, $close, $left + strlen($prefix));
            if ($right === false) {
                $right = strlen($item);
            }
            
            $textPiece = substr($item, $left + strlen($prefix), $right - ($left + strlen($prefix)));
            $piece = $textPiece;
            
            if (Str::contains($textPiece, "{")) {
                $auxLeft = stripos($textPiece, "{");
                $auxRight = stripos($textPiece, "}", $auxLeft) + 1;
                $auxJson = substr($textPiece, $auxLeft, $auxRight - $auxLeft);
                $cleanTextPiece = str_replace($auxJson, "*****", $textPiece);
                $auxJson = str_replace(["'", ", }"], ['"', "}"], $auxJson);
                $auxArr = explode(",", str_replace([" ,", ", "], [",", ","], $cleanTextPiece));
                if (($auxIndex = array_search("*****", $auxArr)) !== false) {
                    $auxArr[$auxIndex] = json_decode($auxJson, true);
                } else {
                    $auxArr[] = json_decode($auxJson, true);
                }
                
                $piece = call_user_func_array($function, $auxArr);
            } else {
                $auxArr = explode(",", str_replace([" ,", ", "], [",", ","], $textPiece));
                if ($function == "trans") {
                    $piece = trans((string)($auxArr[0] ?? ""));
                } elseif ($function == "url") {
                    $piece = url((string)($auxArr[0] ?? ""));
                } else {
                    $piece = call_user_func_array($function, $auxArr);
                }
            }
            
            if (is_string($piece)) {
                $item = substr($item, 0, $left) . $piece . substr($item, $right + strlen($close));
                $left = stripos($item, $prefix);
            } else {
                $item = $piece;
                $left = false;
            }
        }
        return $item;
    }
}
