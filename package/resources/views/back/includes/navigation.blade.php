<li class="{{ isActiveRoute('back.products-finder.*') }}">
    <a href="#"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Products Finder</span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        @include('admin.module.products-finder.products::back.includes.package_navigation')
        @include('admin.module.products-finder.classifiers.entries::back.includes.package_navigation')
    </ul>
</li>
