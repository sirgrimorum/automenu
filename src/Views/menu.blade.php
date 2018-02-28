@if($config["menu_stack"]!="")
@push($config["menu_stack"])
@endif
<nav class="navbar navbar-expand-lg {{array_get($config,"classes.navbar_extra")}}" role="navigation">
    <a class="navbar-brand {{array_get($config,"classes.navbar_brand")}}" href="{{array_get($config,"menu.brand_url")}}">
        @if(array_get($config,"menu.brand_img")!="")
        <img src="{{array_get($config,"menu.brand_img")}}"  height="30" class="d-inline-block align-top {{array_get($config,"classes.brand_img")}}" alt="">
        @endif
        {!!array_get($config,"menu.brand_text")!!}
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar{{ucfirst($config['id'])}}" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse {{array_get($config,"classes.navbar_collapse")}}" id="navbar{{ucfirst($config['id'])}}">
        <ul class="navbar-nav mr-auto {{array_get($config,"classes.navbar_nav_izquierdo")}}">
            @include("automenu::menulado",["menuItems"=>$config["menu"]["izquierdo"],"config"=>$config])
            @if($config["menuitem_izquierda_stack"]!="")
            @stack($config["menuitem_izquierda_stack"])
            @endif
        </ul>
        <ul class="navbar-nav ml-auto {{array_get($config,"classes.navbar_nav_derecho")}}">
            @include("automenu::menulado",["menuItems"=>array_get($config, "menu.derecho"),"config"=>$config])
            @if($config["menuitem_derecha_stack"]!="")
            @stack($config["menuitem_derecha_stack"])
            @endif
        </ul>
    </div>
</nav>
@if($config["menu_stack"]!="")
@endpush
@endif
