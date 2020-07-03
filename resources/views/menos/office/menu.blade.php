

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">

      <div class="sidebar-sticky pt-3">
        
        
          
          
          
        
        <!--h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
          <span>Red</span>
        </h6-->
      <ul class="nav flex-column nav-pills">
        @foreach($business_menu->items as $item)
        <li class="nav-item">
          <a href="{{ Request::url() == $item->url() ? '#' : $item->url() }}" class="nav-link {{ Request::url() == $item->url() ? 'active' : '' }}">{{ $item->title }}</a>
        </li>
        @endforeach
        </ul>
      </div>
    </nav>
    <style>
        body {
  font-size: .875rem;
}

/*
 * Sidebar
 */

.sidebar {
  top: 0;
  bottom: 0;
  left: 0;
  z-index: 100; /* Behind the navbar */
  padding: 0; /* Height of navbar */
  box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
}

.sidebar a.active{
  color: white !important;
}

@media (max-width: 767.98px) {
  .sidebar {
    top: 5rem;
  }
}

.sidebar-sticky {
  position: relative;
  top: 0;
  height: calc(100vh - 48px);
  padding-top: .5rem;
  overflow-x: hidden;
  overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
}

@supports ((position: -webkit-sticky) or (position: sticky)) {
  .sidebar-sticky {
    position: -webkit-sticky;
    position: sticky;
  }
}

.sidebar .nav-link {
  font-weight: 500;
  color: #333;
}

.sidebar .nav-link .feather {
  margin-right: 4px;
  color: #999;
}

.sidebar .nav-link.active {
  color: #007bff;
}

.sidebar .nav-link:hover .feather,
.sidebar .nav-link.active .feather {
  color: inherit;
}

.sidebar-heading {
  font-size: .75rem;
  text-transform: uppercase;
}


    </style>

    <script type="text/javascript">

    </script>
