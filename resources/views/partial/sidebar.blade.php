<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">            
            <a class="nav-link" href="{{url('dashboard')}}">
                <i class="mdi mdi-view-dashboard-outline menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>            
        </li>
        <li><hr></li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#master" aria-expanded="false" aria-controls="master">
                <i class="mdi mdi-puzzle-outline menu-icon"></i>
                <span class="menu-title">Master</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="master">
                <ul class="nav flex-column sub-menu">                    
                    <li class="nav-item"> <a class="nav-link" href="{{url('marketplace')}}">Marketplace</a></li>                    
                    <li class="nav-item"> <a class="nav-link" href="{{url('kurir')}}">Kurir</a></li>
                </ul>
            </div>
        </li>        
        <li class="nav-item">
            <a class="nav-link" href="{{url('pengiriman')}}">
                <i class="mdi mdi-puzzle-outline menu-icon"></i>
                <span class="menu-title">Pengiriman</span>
                <!-- <i class="menu-arrow"></i> -->
            </a>            
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#setting" aria-expanded="false" aria-controls="setting">
                <i class="mdi mdi-puzzle-outline menu-icon"></i>
                <span class="menu-title">Setting</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="setting">
                <ul class="nav flex-column sub-menu">                                                            
                    <li class="nav-item"> <a class="nav-link" href="{{url('user')}}">User</a></li>
                </ul>
            </div>
        </li>
    </ul>
</nav>