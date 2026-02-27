<?php
$classItem = "nav-item";
$classText = "navbar-text";
$classDivider = $classItem  . " divider";
$typeDivider = "li";
$typeItem = "li";

$classItem2 = "dropdown-item";
$classText2 = "dropdown-item disabled";
$classDivider2 = "dropdown-divider";
$typeDivider2 = "a";
$typeItem2 = "div";
if(\Illuminate\Support\Arr::get($config,"menu.brand_center")){
    $classItem = "dropdown-item " . $class_extra_item;
    $classText = "dropdown-item disabled";
    $classDivider = "dropdown-divider";
    $typeDivider = "div";
    $typeItem = "span";
}
foreach ($menuItems as $nombre => $datos) {
    $nombre = Sirgrimorum\AutoMenu\AutoMenu::replaceUser($nombre, $config);
    if (is_array($datos)) {
        if (isset($datos['logedin']) && isset($datos['items'])) {
            if (Sirgrimorum\AutoMenu\AutoMenu::hasAccess($datos['logedin'])) {
                if (is_array($datos['items'])) {
                    $classExtra = " " . $class_extra_item . " " . $class_extra_item_primero;
                    $class_extra_item_primero = "";
                    ?>
                    <{{$typeItem}} class="{{$classItem . $classExtra}} dropdown">
                        <a href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {!! $nombre !!}
                        </a>
                        <div class="dropdown-menu">
                            <?php
                            foreach ($datos['items'] as $nombre2 => $datos2) {
                                $nombre2 = Sirgrimorum\AutoMenu\AutoMenu::replaceUser($nombre2, $config);
                                if (is_array($datos2)) {
                                    if (isset($datos2['logedin']) && isset($datos2['item'])) {
                                        if (AutoMenu::hasAccess($datos2['logedin'])) {
                                            if (stripos($datos2['item'], "blade:") !== false) {
                                                ?>
                                                @include(str_replace("blade:","",$datos2['item']))
                                                <?php
                                            } elseif (is_array($datos2['item'])) {
                                                if (serialize($datos2['item']) == app('request')->fullUrl()) {
                                                    $active = " active";
                                                }else{
                                                    $active = "";
                                                }
                                                ?>
                                                 <{{$typeItem2}} class="{{$classItem2 . " " . $class_extra_item_interno . $active}}">
                                                <a class="nav-link" href="{{print_r($datos2['item']) }}">{!! $nombre2 !!}</a>
                                                </{{$typeItem2}}>
                                                <?php
                                            } elseif ($nombre2 == 'text') {
                                                $datos2['item'] = Sirgrimorum\AutoMenu\AutoMenu::replaceUser($datos2['item'], $config);
                                                ?>
                                                <span class="dropdown-item">
                                                    {!! $datos2['item'] !!}
                                                </span>
                                                <?php
                                            } elseif (stripos($datos2['item'], "blade:") !== false) {
                                                ?>
                                                @include(str_replace("blade:","",$datos2['item']))
                                                <?php
                                            } else {
                                                if ($datos2['item'] == app('request')->fullUrl()) {
                                                    $active = " active";
                                                }else{
                                                    $active = "";
                                                }
                                                ?>
                                                <{{$typeItem2}} class="{{$classItem2 . " " . $class_extra_item_interno . $active}}">
                                                <a class="nav-link" href="{{$datos2['item'] }}">{!! $nombre2 !!}</a>
                                                </{{$typeItem2}}>
                                                <?php
                                            }
                                        }
                                    }
                                } elseif ($datos2 == '_') {
                                    ?>
                                    <div class="dropdown-divider"></div>
                                    <?php
                                } elseif ($nombre2 == 'text') {
                                    $datos2 = Sirgrimorum\AutoMenu\AutoMenu::replaceUser($datos2, $config);
                                    ?>
                                    <span class="dropdown-item {{$class_extra_item_interno}}">
                                        {!! $datos2 !!}
                                    </span>
                                    <?php
                                } elseif (stripos($datos2, "blade:") !== false) {
                                    ?>
                                    @include(str_replace("blade:","",$datos2))
                                    <?php
                                } else {
                                    if ($datos2 == app('request')->fullUrl()) {
                                        $active = " active";
                                    }else{
                                        $active = "";
                                    }
                                    ?>
                                     <{{$typeItem2}} class="{{$classItem2 . " " . $class_extra_item_interno . $active}}">
                                    <a class="nav-link" href="{{ $datos2 }}">{!! $nombre2 !!}</a>
                                    </{{$typeItem2}}>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </{{$typeItem}}>
                    <?php
                } elseif ($datos['items'] == '_') {
                    ?>
                    <{{$typeDivider}} class="{{$classDivider}}"></{{$typeDivider}}>
                    <?php
                } elseif ($nombre == 'text') {
                    $datos['items'] = Sirgrimorum\AutoMenu\AutoMenu::replaceUser($datos['items'], $config);
                    $classExtra = " " . $class_extra_item . " " . $class_extra_item_primero;
                    $class_extra_item_primero = "";
                    ?>
                    <span class="{{$classText . $classExtra}}">
                        {!! $datos['items'] !!}
                    </span>
                    <?php
                } elseif (stripos($datos['items'], "blade:") !== false) {
                    ?>
                    @include(str_replace("blade:","",$datos['items']))
                    <?php
                } else {
                    $classExtra = " " . $class_extra_item . " " . $class_extra_item_primero;
                    $class_extra_item_primero = "";
                    if ($datos['items'] == app('request')->fullUrl()) {
                        $active = " active";
                    }else{
                        $active = "";
                    }
                    ?>
                    <{{$typeItem}} class="{{$classItem . $classExtra . $active}}">
                        <a class="nav-link" href="{{ $datos['items'] }}">
                            {!! $nombre!!}
                        </a>
                    </{{$typeItem}}>
                    <?php
                }
            }
        } elseif (isset($datos['logedin']) && isset($datos['item'])) {
            if (Sirgrimorum\AutoMenu\AutoMenu::hasAccess($datos['logedin'])) {
                $classExtra = " " . $class_extra_item . " " . $class_extra_item_primero;
                $class_extra_item_primero = "";
                if ($datos['item'] == app('request')->fullUrl()) {
                    $active = " active";
                }else{
                    $active = "";
                }
                ?>
                <{{$typeItem}} class="{{$classItem . $classExtra . $active}}">
                    <a class="nav-link" href="{{ $datos['item'] }}">
                        {!! $nombre!!}
                    </a>
                </{{$typeItem}}>
                <?php
            }
        }
    } elseif ($nombre == '_') {
        ?>
        <{{$typeDivider}} class="{{$classDivider}}"></{{$typeDivider}}>
        <?php
    } elseif ($nombre == 'text') {
        $classExtra = " " . $class_extra_item . " " . $class_extra_item_primero;
        $class_extra_item_primero = "";
        $datos = Sirgrimorum\AutoMenu\AutoMenu::replaceUser($datos, $config);
        ?>
        <span class="{{$classText . $classExtra}}">
            {!! $datos !!}
        </span>
        <?php
    } else {
        $classExtra = " " . $class_extra_item . " " . $class_extra_item_primero;
        $class_extra_item_primero = "";
        if ($datos == app('request')->fullUrl()) {
            $active = " active";
        }else{
            $active = "";
        }
        ?>
        <{{$typeItem}} class="{{$classItem . $classExtra . $active}}">
            <a class="nav-link" href="{{ $datos }}">
                {!!$nombre!!}
            </a>
        </{{$typeItem}}>
        <?php
    }
}
?>
