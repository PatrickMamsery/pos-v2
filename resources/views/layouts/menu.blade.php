<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link active">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>
<li class="nav-item has-treeview {{ activeSegment('products') }}">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-th-large"></i>
        <p>Products <i class="right fas fa-angle-left"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('products.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Product List</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('products.create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Product</p>
            </a>
        </li>
    </ul>
</li>
<li class="nav-item has-treeview">
    <a href="{{ route('settings.index') }}" class="nav-link {{ activeSegment('settings') }}">
        <i class="nav-icon fas fa-cogs"></i>
        <p>Settings</p>
    </a>
</li>
<li class="nav-item">
    <a href="#" class="nav-link" onclick="document.getElementById('logout-form').submit()">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Logout</p>
        <form action="{{route('logout')}}" method="POST" id="logout-form">
            @csrf
        </form>
    </a>
</li>
