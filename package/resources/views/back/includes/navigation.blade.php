<li class="{{ isActiveRoute('back.products-finder.*', 'mm-active') }}">
    <a href="#" aria-expanded="false"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Products Finder</span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level">
        @include('admin.module.products-finder.products::back.includes.package_navigation')
        @include('admin.module.products-finder.reviews.messages::back.includes.package_navigation')
        @include('admin.module.products-finder.classifiers.entries::back.includes.package_navigation')
    </ul>
</li>
