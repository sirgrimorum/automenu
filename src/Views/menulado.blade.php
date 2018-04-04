<?php
$classItem = "nav-item";
$classText = "navbar-text";
$classDivider = $classItem  . " divider";
$typeDivider = "li";
$typeItem = "li";
if(array_get($config,"menu.brand_center")){
    $classItem = "dropdown-item";
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
                    ?>
                    <{{$typeItem}} class="{{$classItem}} dropdown">
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
                                                ?>
                                                 <{{$typeItem}} class="{{$classItem}}">
                                                <a class="nav-link" href="{{print_r($datos2['item']) }}">{!! $nombre2 !!}</a>
                                                </{{$typeItem}}>
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
                                                ?>
                                                <{{$typeItem}} class="{{$classItem}}">
                                                <a class="nav-link" href="{{$datos2['item'] }}">{!! $nombre2 !!}</a>
                                                </{{$typeItem}}>
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
                                    <span class="dropdown-item">
                                        {!! $datos2 !!}
                                    </span>
                                    <?php
                                } elseif (stripos($datos2, "blade:") !== false) {
                                    ?>
                                    @include(str_replace("blade:","",$datos2))
                                    <?php
                                } else {
                                    ?>
                                     <{{$typeItem}} class="{{$classItem}}">
                                    <a class="nav-link" href="{{ $datos2 }}">{!! $nombre2 !!}</a>
                                    </{{$typeItem}}>
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
                    ?>
                    <span class="{{$classText}}">
                        {!! $datos['items'] !!}
                    </span>
                    <?php
                } elseif (stripos($datos['items'], "blade:") !== false) {
                    ?>
                    @include(str_replace("blade:","",$datos['items']))
                    <?php
                } else {
                    ?>
                    <{{$typeItem}} class="{{$classItem}}">
                        <a class="nav-link" href="{{ $datos['items'] }}">
                            {!! $nombre !!}
                        </a>
                    </{{$typeItem}}>
                    <?php
                }
            }
        }
    } elseif ($nombre == '_') {
        ?>
        <{{$typeDivider}} class="{{$classDivider}}"></{{$typeDivider}}>
        <?php
    } elseif ($nombre == 'text') {
        $datos = Sirgrimorum\AutoMenu\AutoMenu::replaceUser($datos, $config);
        ?>
        <span class="{{$classText}}">
            {!! $datos !!}
        </span>
        <?php
    } else {
        ?>
        <{{$typeItem}} class="{{$classItem}}">
            <a class="nav-link" href="{{ $datos }}">
                {!!$nombre!!}
            </a>
        </{{$typeItem}}>
        <?php
    }
}
?>