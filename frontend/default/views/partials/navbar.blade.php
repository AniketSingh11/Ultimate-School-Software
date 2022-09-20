<nav class="navbar header-menu-area">
    <!-- Start container -->
    <div class="container">
        <!-- Logo and toggle  -->
        <div class="navbar-header">
            <button aria-expanded="false" data-target="#navbar-collaps" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- Start Logo -->
            <div class="logo text-uppercase">
                <h1>
                    @if(count($homepage))
                        <a href="{{ base_url('frontend/page/'.$homepage->url) }}"> {{ frontendColorStyle(namesorting($backend->sname, 20)) }} </a>
                    @else
                        <a> {{ frontendColorStyle(namesorting($backend->sname, 20)) }} </a>
                    @endif
                    
                </h1>
            </div>
            <!-- End Logo -->
        </div>
        <!-- main menu start -->
        <div id="navbar-collaps" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                {{ frontendData::get_frontent_topbar_menu() }}
            </ul>
        </div>   <!-- /.navbar-collapse -->
    </div>   <!-- End container -->
</nav>
