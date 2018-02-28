<?php
foreach ($menuItems as $nombre => $datos) {
    $nombre = Sirgrimorum\AutoMenu\AutoMenu::replaceUser($nombre, $config);
    if (is_array($datos)) {
        if (isset($datos['logedin']) && isset($datos['items'])) {
            if (Sirgrimorum\AutoMenu\AutoMenu::hasAccess($datos['logedin'])) {
                if (is_array($datos['items'])) {
                    ?>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ $nombre }}
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
                                                <a class="dropdown-item" href="{{print_r($datos2['item']) }}">{{ $nombre2 }}</a>
                                                <?php
                                            } elseif ($nombre2 == 'text') {
                                                ?>
                                                <span class="dropdown-item">
                                                    {{ $datos2['item'] }}
                                                </span>
                                                <?php
                                            } elseif (stripos($datos2['item'], "blade:") !== false) {
                                                ?>
                                                @include(str_replace("blade:","",$datos2['item']))
                                                <?php
                                            } else {
                                                ?>
                                                <a class="dropdown-item" href="{{$datos2['item'] }}">{{ $nombre2 }}</a>
                                                <?php
                                            }
                                        }
                                    }
                                } elseif ($datos2 == '_') {
                                    ?>
                                    <div class="dropdown-divider"></div>
                                    <?php
                                } elseif ($nombre2 == 'text') {
                                    ?>
                                    <span class="dropdown-item">
                                        {{ $datos2 }}
                                    </span>
                                    <?php
                                } elseif (stripos($datos2, "blade:") !== false) {
                                    ?>
                                    @include(str_replace("blade:","",$datos2))
                                    <?php
                                } else {
                                    ?>
                                    <a class="dropdown-item" href="{{ $datos2 }}">{{ $nombre2 }}</a>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </li>
                    <?php
                } elseif ($datos['items'] == '_') {
                    ?>
                    <li class="nav-item divider"></li>
                    <?php
                } elseif ($nombre == 'text') {
                    ?>
                    <span class="navbar-text">
                        {{ $datos['items'] }}
                    </span>
                    <?php
                } elseif (stripos($datos['items'], "blade:") !== false) {
                    ?>
                    @include(str_replace("blade:","",$datos['items']))
                    <?php
                } else {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $datos['items'] }}">
                            {{ $nombre }}
                        </a>
                    </li>
                    <?php
                }
            }
        }
    } elseif ($nombre == '_') {
        ?>
        <li class="nav-item divider"></li>
        <?php
    } elseif ($nombre == 'text') {
        ?>
        <span class="navbar-text">
            {{ $datos }}
        </span>
        <?php
    } else {
        ?>
        <li class="nav-item">
            <a class="nav-link" href="{{ $datos }}">
                {{$nombre}}
            </a>
        </li>
        <?php
    }
}
?>