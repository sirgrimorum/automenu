@if($config["menu_stack"]!="")
@push($config["menu_stack"])
@endif
<nav class="navbar navbar-expand-lg {{\Illuminate\Support\Arr::get($config,"classes.navbar_extra")}}" role="navigation">
    @if(!\Illuminate\Support\Arr::get($config,"menu.brand_center"))
    @if(\Illuminate\Support\Arr::get($config,"menu.brand_img")!="" || \Illuminate\Support\Arr::get($config,"menu.brand_text")!="")
    <a class="navbar-brand {{\Illuminate\Support\Arr::get($config,"classes.navbar_brand")}}" href="{{\Illuminate\Support\Arr::get($config,"menu.brand_url")}}">
        @if(\Illuminate\Support\Arr::get($config,"menu.brand_img")!="")
        <img src="{{ \Illuminate\Support\Arr::get($config,"menu.brand_img") }}"  height="{{ \Illuminate\Support\Arr::get($config,"classes.brand_img_height", 30) }}" class="d-inline-block align-top {{\Illuminate\Support\Arr::get($config,"classes.brand_img")}}" alt="">
        @endif
        {!!\Illuminate\Support\Arr::get($config,"menu.brand_text")!!}
    </a>
    @endif
    <button class="navbar-toggler {{\Illuminate\Support\Arr::get($config,"classes.button_izquierdo")}}" type="button" data-toggle="collapse" data-target="#navbar{{ucfirst($config['id'])}}" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="{{\Illuminate\Support\Arr::get($config,"icons.left",'fa fa-bars')}}"></i>
    </button>
    <div class="collapse navbar-collapse {{\Illuminate\Support\Arr::get($config,"classes.navbar_collapse")}}" id="navbar{{ucfirst($config['id'])}}">
        @if($config["menu"]["izquierdo"]!="")
        <ul class="navbar-nav {{\Illuminate\Support\Arr::get($config,"classes.navbar_nav_izquierdo")}}">
            @include("automenu::menulado",["menuItems"=>$config["menu"]["izquierdo"],"config"=>$config,"class_extra_item"=>\Illuminate\Support\Arr::get($config,"classes.item_izquierdo"),"class_extra_item_primero"=>\Illuminate\Support\Arr::get($config,"classes.item_izquierdo_primero"),"class_extra_item_interno"=>\Illuminate\Support\Arr::get($config,"classes.item_izquierdo_interno")])
            @if($config["menuitem_izquierda_stack"]!="")
            @stack($config["menuitem_izquierda_stack"])
            @endif
        </ul>
        @endif
        @if($config["menu"]["derecho"]!="")
        <ul class="navbar-nav {{\Illuminate\Support\Arr::get($config,"classes.navbar_nav_derecho")}}">
            @include("automenu::menulado",["menuItems"=>\Illuminate\Support\Arr::get($config, "menu.derecho"),"config"=>$config,"class_extra_item"=>\Illuminate\Support\Arr::get($config,"classes.item_derecho"),"class_extra_item_primero"=>\Illuminate\Support\Arr::get($config,"classes.item_derecho_primero"),"class_extra_item_interno"=>\Illuminate\Support\Arr::get($config,"classes.item_derecho_interno")])
            @if($config["menuitem_derecha_stack"]!="")
            @stack($config["menuitem_derecha_stack"])
            @endif
        </ul>
        @endif
    </div>
    @else
    <div class="dropdown">
        @if($config["menu"]["izquierdo"]!="")
        <button class="nav-item btn {{\Illuminate\Support\Arr::get($config,"classes.button_izquierdo")}}" type="button" id="navbar{{ucfirst($config['id'])}}_i_l" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="{{\Illuminate\Support\Arr::get($config,"icons.left",'fa fa-bars')}}"></i>
        </button>
        <div class="dropdown-menu {{\Illuminate\Support\Arr::get($config,"classes.navbar_collapse")}}" id="navbar{{ucfirst($config['id'])}}_i" aria-labelledby="navbar{{ucfirst($config['id'])}}_i_l">
            <div class="{{\Illuminate\Support\Arr::get($config,"classes.navbar_nav_izquierdo")}}" >
                @include("automenu::menulado",["menuItems"=>$config["menu"]["izquierdo"],"config"=>$config,"class_extra_item"=>\Illuminate\Support\Arr::get($config,"classes.item_izquierdo"),"class_extra_item_primero"=>\Illuminate\Support\Arr::get($config,"classes.item_izquierdo_primero"),"class_extra_item_interno"=>\Illuminate\Support\Arr::get($config,"classes.item_izquierdo_interno")])
                @if($config["menuitem_izquierda_stack"]!="")
                @stack($config["menuitem_izquierda_stack"])
                @endif
            </div>
        </div>
        @endif
    </div>
    <div>
        <a class="navbar-brand {{\Illuminate\Support\Arr::get($config,"classes.navbar_brand")}}" href="{{\Illuminate\Support\Arr::get($config,"menu.brand_url")}}">
            @if(\Illuminate\Support\Arr::get($config,"menu.brand_img")!="")
            <img src="{{\Illuminate\Support\Arr::get($config,"menu.brand_img")}}"  height="30" class="d-inline-block align-top {{\Illuminate\Support\Arr::get($config,"classes.brand_img")}}" alt="">
            @endif
            {!!\Illuminate\Support\Arr::get($config,"menu.brand_text")!!}
        </a>
    </div>
    <div class="dropdown">
        @if($config["menu"]["derecho"]!="")
        <button class="nav-item btn {{\Illuminate\Support\Arr::get($config,"classes.button_derecho")}}" type="button" id="navbar{{ucfirst($config['id'])}}_d_l" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="{{\Illuminate\Support\Arr::get($config,"icons.right",'fa fa-bars')}}"></i>
        </button>
        <div class="dropdown-menu {{\Illuminate\Support\Arr::get($config,"classes.navbar_collapse")}}" style="right: 0px;left: auto;" id="navbar{{ucfirst($config['id'])}}_d" aria-labelledby="navbar{{ucfirst($config['id'])}}_d_l">
            <div class="{{\Illuminate\Support\Arr::get($config,"classes.navbar_nav_derecho")}}">
                @include("automenu::menulado",["menuItems"=>\Illuminate\Support\Arr::get($config, "menu.derecho"),"config"=>$config,"class_extra_item"=>\Illuminate\Support\Arr::get($config,"classes.item_derecho"),"class_extra_item_primero"=>\Illuminate\Support\Arr::get($config,"classes.item_derecho_primero"),"class_extra_item_interno"=>\Illuminate\Support\Arr::get($config,"classes.item_derecho_interno")])
                @if($config["menuitem_derecha_stack"]!="")
                @stack($config["menuitem_derecha_stack"])
                @endif
            </div>
        </div>
        @endif
    </div>
    @endif
</nav>
@if($config["menu_stack"]!="")
@endpush
@endif
