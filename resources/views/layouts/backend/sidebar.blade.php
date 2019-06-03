<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ Auth::user()->gravatar() }}" class="img-circle" alt="{{ Auth::user()->name }}">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->name }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li>
                <a href="{{ url('/backend/home') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-pencil"></i>
                    <span>Blog</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('backend.blog.index') }}"><i class="fa fa-circle-o"></i> All Posts</a></li>
                    <li><a href="{{ route('backend.blog.create') }}"><i class="fa fa-circle-o"></i> Add New</a></li>
                </ul>
            </li>
            @role(['editor', 'admin'])
            <li>
                <a href="#">
                    <i class="fa fa-folder"></i>
                    <span>Categories</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('backend.category.index') }}"><i class="fa fa-circle-o"></i> All Categories</a></li>
                    <li><a href="{{ route('backend.category.create') }}"><i class="fa fa-circle-o"></i> Add New</a></li>
                </ul>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-tag"></i>
                    <span>Tags</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('backend.tag.index') }}"><i class="fa fa-circle-o"></i> All Tags</a></li>
                    <li><a href="{{ route('backend.tag.create') }}"><i class="fa fa-circle-o"></i> Add New</a></li>
                </ul>
            </li>
            @endrole
            @role('admin')
            <li>
                <a href="#">
                    <i class="fa fa-users"></i>
                    <span>Users</span>
                    <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ route('backend.user.index') }}"><i class="fa fa-circle-o"></i> All Users</a></li>
                    <li><a href="{{ route('backend.user.create') }}"><i class="fa fa-circle-o"></i> Add New</a></li>
                </ul>
            </li>
            @endrole
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>