<div class="center">
    <div class="center-item">
        <div class="center-heading">Main Home</div>
        <ul class="menu-list">
            <li class="menu-item">
                <a href="index.html" class="">
                    <div class="icon"><i class="icon-grid"></i></div>
                    <div class="text">Dashboard</div>
                </a>
            </li>
        </ul>
    </div>
    <div class="center-item">
        <ul class="menu-list">
            <li class="menu-item has-children {{  request()->routeIs('product.index') || request()->routeIs('product.create')|| request()->routeIs('product.edit') ? 'active' : ''}}">
                <a href="javascript:void(0);" class="menu-item-button">
                    <div class="icon"><i class="icon-shopping-cart"></i></div>
                    <div class="text">Products</div>
                </a>
                <ul class="sub-menu">
                    <li class="sub-menu-item">
                        <a href="{{ route('product.create') }}" class="{{ request()->routeIs('product.create') ? 'active' : '' }}">
                            <div class="text">Add Product</div>
                        </a>
                    </li>
                    <li class="sub-menu-item">
                        <a href="{{ route('product.index') }}" class="{{ request()->routeIs('product.index') ? 'active' : '' }}">
                            <div class="text">Products</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item has-children {{  request()->routeIs('brand.index') || request()->routeIs('brand.create')|| request()->routeIs('brand.edit') ? 'active' : ''}}">
                <a href=" javascript:void(0);" class="menu-item-button">
                    <div class="icon"><i class="icon-layers"></i></div>
                    <div class="text">Brand</div>
                </a>
                <ul class="sub-menu">
                    <li class="sub-menu-item">
                        <a href="{{ route('brand.create') }}" class="{{ request()->routeIs('brand.create') ? 'active' : '' }}">
                            <div class="text">New Brand</div>
                        </a>
                    </li>
                    <li class="sub-menu-item">
                        <a href="{{ route('brand.index') }}" class="{{ request()->routeIs('brand.index') ? 'active' : '' }}">
                            <div class=" text">Brands
                            </div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item has-children {{  request()->routeIs('category.index') || request()->routeIs('category.create')|| request()->routeIs('category.edit') ? 'active' : ''}}">
                <a href="javascript:void(0);" class="menu-item-button">
                    <div class="icon"><i class="icon-layers"></i></div>
                    <div class="text">Category</div>
                </a>
                <ul class="sub-menu">
                    <li class="sub-menu-item">
                        <a href="{{ route('category.create') }}" class="{{ request()->routeIs('category.create') ? 'active' : '' }}">
                            <div class="text">New Category</div>
                        </a>
                    </li>
                    <li class="sub-menu-item">
                        <a href="{{ route('category.index') }}" class="{{ request()->routeIs('category.index') ? 'active' : '' }}">
                            <div class="text">Categories</div>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="menu-item has-children">
                <a href="javascript:void(0);" class="menu-item-button">
                    <div class="icon"><i class="icon-file-plus"></i></div>
                    <div class="text">Order</div>
                </a>
                <ul class="sub-menu">
                    <li class="sub-menu-item">
                        <a href="orders.html" class="">
                            <div class="text">Orders</div>
                        </a>
                    </li>
                    <li class="sub-menu-item">
                        <a href="order-tracking.html" class="">
                            <div class="text">Order tracking</div>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="menu-item">
                <a href="slider.html" class="">
                    <div class="icon"><i class="icon-image"></i></div>
                    <div class="text">Slider</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="coupons.html" class="">
                    <div class="icon"><i class="icon-grid"></i></div>
                    <div class="text">Coupns</div>
                </a>
            </li>

            <li class="menu-item">
                <a href="users.html" class="">
                    <div class="icon"><i class="icon-user"></i></div>
                    <div class="text">User</div>
                </a>
            </li>

            <li class="menu-item">
                <a href="settings.html" class="">
                    <div class="icon"><i class="icon-settings"></i></div>
                    <div class="text">Settings</div>
                </a>
            </li>
            <li class="menu-item has-children {{ request()->routeIs('permission.index') || request()->routeIs('permission.create') || request()->routeIs('permission.edit') ? 'active' : ''}}">
                <a href="javascript:void(0);" class="menu-item-button">
                    <div class="icon"><i class="icon-settings"></i></div>
                    <div class="text">Settings</div>
                </a>
                <ul class="sub-menu">
                    @can('view permission')
                    <li class="sub-menu-item">
                        <a href="{{ route('permission.index') }}" class="{{ request()->routeIs('permission.index') || request()->routeIs('permission.create') || request()->routeIs('permission.edit') ? 'active' : ''}}">
                            <div class="text">Permissions</div>
                        </a>
                    </li>
                    @endcan
                    <li class="sub-menu-item">
                        <a href="products.html" class="">
                            <div class="text">Role</div>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
