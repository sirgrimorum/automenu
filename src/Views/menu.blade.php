@if($config["menu_stack"]!="")
@push($config["menu_stack"])
@endif
<nav class="navbar navbar-expand-lg {{array_get($config,"classes.navbar_extra")}}" role="navigation">
    @if(!array_get($config,"menu.brand_center"))
    @if(array_get($config,"menu.brand_img")!="" || array_get($config,"menu.brand_text")!="")
    <a class="navbar-brand {{array_get($config,"classes.navbar_brand")}}" href="{{array_get($config,"menu.brand_url")}}">
        @if(array_get($config,"menu.brand_img")!="")
        <img src="{{array_get($config,"menu.brand_img")}}"  height="30" class="d-inline-block align-top {{array_get($config,"classes.brand_img")}}" alt="">
        @endif
        {!!array_get($config,"menu.brand_text")!!}
    </a>
    @endif
    <button class="navbar-toggler {{array_get($config,"classes.button_izquierdo")}}" type="button" data-toggle="collapse" data-target="#navbar{{ucfirst($config['id'])}}" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fa {{array_get($config,"icons.left",'fa-bars')}}"></i>
    </button>
    <div class="collapse navbar-collapse {{array_get($config,"classes.navbar_collapse")}}" id="navbar{{ucfirst($config['id'])}}">
        @if($config["menu"]["izquierdo"]!="")
        <ul class="navbar-nav mr-auto {{array_get($config,"classes.navbar_nav_izquierdo")}}">
            @include("automenu::menulado",["menuItems"=>$config["menu"]["izquierdo"],"config"=>$config,"class_extra_item"=>array_get($config,"classes.item_izquierdo")])
            @if($config["menuitem_izquierda_stack"]!="")
            @stack($config["menuitem_izquierda_stack"])
            @endif
        </ul>
        @endif
        @if($config["menu"]["derecho"]!="")
        <ul class="navbar-nav ml-auto {{array_get($config,"classes.navbar_nav_derecho")}}">
            @include("automenu::menulado",["menuItems"=>array_get($config, "menu.derecho"),"config"=>$config,"class_extra_item"=>array_get($config,"classes.item_derecho")])
            @if($config["menuitem_derecha_stack"]!="")
            @stack($config["menuitem_derecha_stack"])
            @endif
        </ul>
        @endif
    </div>
    @else
    <div class="dropdown">
        @if($config["menu"]["izquierdo"]!="")
        <button class="nav-item btn {{array_get($config,"classes.button_izquierdo")}}" type="button" id="navbar{{ucfirst($config['id'])}}_i_l" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa {{array_get($config,"icons.left",'fa-bars')}}"></i>
        </button>
        <div class="dropdown-menu {{array_get($config,"classes.navbar_collapse")}}" id="navbar{{ucfirst($config['id'])}}_i" aria-labelledby="navbar{{ucfirst($config['id'])}}_i_l">
            <div class="mr-auto {{array_get($config,"classes.navbar_nav_izquierdo")}}" >
                @include("automenu::menulado",["menuItems"=>$config["menu"]["izquierdo"],"config"=>$config,"class_extra_item"=>array_get($config,"classes.item_izquierdo")])
                @if($config["menuitem_izquierda_stack"]!="")
                @stack($config["menuitem_izquierda_stack"])
                @endif
            </div>
        </div>
        @endif
    </div>
    <div>
        <a class="navbar-brand {{array_get($config,"classes.navbar_brand")}}" href="{{array_get($config,"menu.brand_url")}}">
            @if(array_get($config,"menu.brand_img")!="")
            <img src="{{array_get($config,"menu.brand_img")}}"  height="30" class="d-inline-block align-top {{array_get($config,"classes.brand_img")}}" alt="">
            @endif
            {!!array_get($config,"menu.brand_text")!!}
        </a>
    </div>
    <div class="dropdown">
        @if($config["menu"]["derecho"]!="")
        <button class="nav-item btn {{array_get($config,"classes.button_derecho")}}" type="button" id="navbar{{ucfirst($config['id'])}}_d_l" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa {{array_get($config,"icons.right",'fa-bars')}}"></i>
        </button>
        <div class="dropdown-menu {{array_get($config,"classes.navbar_collapse")}}" style="right: 0px;left: auto;" id="navbar{{ucfirst($config['id'])}}_d" aria-labelledby="navbar{{ucfirst($config['id'])}}_d_l">
            <div class="ml-auto {{array_get($config,"classes.navbar_nav_derecho")}}">
                @include("automenu::menulado",["menuItems"=>array_get($config, "menu.derecho"),"config"=>$config,"class_extra_item"=>array_get($config,"classes.item_derecho")])
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
