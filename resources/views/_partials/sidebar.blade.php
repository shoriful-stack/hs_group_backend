      <aside class="sidebar-wrapper" data-simplebar="true">
          <div class="sidebar-header">
              <div>
                  <img src="/assets/images/HSETL-logo-white fav.png" class="logo-icon" alt="logo icon">
              </div>
              <div class="ms-1">
                  <h4 class="logo-text">HS Engineering & Technology Ltd.</h4>
              </div>
              <div class="toggle-icon ms-auto"><i class="bi bi-chevron-double-left"></i>
              </div>
          </div>
          <!--navigation-->
          <ul class="metismenu" id="menu">
              <li>
                  <a href="{{ route('home') }}" aria-expanded="false">
                      <div class="parent-icon"><i class="bi bi-house-door"></i>
                      </div>
                      <div class="menu-title">Dashboard</div>
                  </a>
              </li>
              @if(auth()->user()->role->hasAnyDirectPermission(['All Solutions','All Solution Categories']))
              <li>
                  <a href="javascript:;" class="has-arrow">
                      <div class="parent-icon"><i class="bi bi-grid"></i>
                      </div>
                      <div class="menu-title">Services</div>
                  </a>
                  <ul>
                      @can('All Solutions')
                      <li> <a href="{{ route('services.index') }}"><i class="bi bi-arrow-right-short"></i>All
                              Service</a>
                      </li>
                      @endcan
                      @can('All Solution Categories')
                      <li> <a href="{{ route('serviceCategories.index') }}"><i
                                  class="bi bi-arrow-right-short"></i>Categories</a>
                      </li>
                      @endcan
                      @can('All Solution Categories')
                      <li> <a href="{{ route('serviceEquipmentCategories.index') }}"><i
                                  class="bi bi-arrow-right-short"></i>Equipment Categories</a>
                      </li>
                      @endcan
                  </ul>
              </li>
              @endif

              @if(auth()->user()->role->hasAnyDirectPermission(['All Blog Categories', 'All Blog Tags', ' All Blogs']))
              <li class="{{ request()->routeIs('projects.*', 'projectCategories.*') ? 'mm-active' : '' }}">
                  <a class="has-arrow" href="javascript:;">
                      <div class="parent-icon"><i class="bi bi-card-checklist"></i>
                      </div>
                      <div class="menu-title">Projects</div>
                  </a>
                  <ul>
                    @can('All Blogs')
                      <li class="{{ request()->routeIs('projects.*') ? 'mm-active' : '' }}"> <a
                              href="{{ route('projects.index') }}"><i class="bi bi-arrow-right-short"></i>All Projects</a>
                      </li>
                    @endcan
                    @can('All Blog Categories')
                      <li class="{{ request()->routeIs('projectCategories.*') ? 'mm-active' : '' }}"> <a
                              href="{{ route('projectCategories.index') }}"><i
                                  class="bi bi-arrow-right-short"></i>Category</a>
                      </li>
                    @endcan
                    @can('All Solution Categories')
                      <li> <a href="{{ route('projectEquipmentCategories.index') }}"><i
                                  class="bi bi-arrow-right-short"></i>Equipment Categories</a>
                      </li>
                      @endcan
                  </ul>
              </li>
              @endif

              @if(auth()->user()->role->hasAnyDirectPermission(['All Product Categories', 'All Products']))
              <li
                  class="{{ request()->routeIs('products.*', 'productCategories.*') ? 'mm-active' : '' }}">
                  <a href="javascript:;" class="has-arrow">
                      <div class="parent-icon"><i class="bi bi-bag-check"></i>
                      </div>
                      <div class="menu-title">Products</div>
                  </a>
                  <ul
                      class="{{ request()->routeIs('products.*', 'productCategories.*') ? 'mm-show' : '' }}">
                      @can('All Products')
                      <li class="{{ request()->routeIs('products.*') ? 'mm-active' : '' }}"> <a
                              href="{{ route('products.index') }}"><i class="bi bi-arrow-right-short"></i>All
                              Products</a>
                      </li>
                      @endcan

                      @can('All Product Categories')
                      <li class="{{ request()->routeIs('productCategories.*') ? 'mm-active' : '' }}"> <a
                              href="{{ route('productCategories.index') }}"><i
                                  class="bi bi-arrow-right-short"></i>Categories</a> </li>
                      @endcan
                  </ul>
              </li>
              @endif
            {{-- @if(auth()->user()->role->hasAnyDirectPermission(['All Pages']))
              <li>
                  <a href="{{ route('pages.index') }}" aria-expanded="false">
                      <div class="parent-icon"><i class="bi bi-file-earmark"></i>
                      </div>
                      <div class="menu-title">Pages</div>
                  </a>
              </li>
              @endif --}}
            @if(auth()->user()->role->hasAnyDirectPermission(['All Awards']))
              <li>
                  <a href="{{ route('awards.index') }}" aria-expanded="false">
                      <div class="parent-icon"><i class="bi bi-award"></i>
                      </div>
                      <div class="menu-title">Awards</div>
                  </a>
              </li>
              @endif
              <li>
                  <a href="{{ route('ourCustomers.index') }}" aria-expanded="false">
                      <div class="parent-icon"><i class="bi bi-person"></i>
                      </div>
                      <div class="menu-title">Customers</div>
                  </a>
              </li>
            @if(auth()->user()->role->hasAnyDirectPermission(['All Contact Messages', 'All Contact Settings']))
              <li class="">
                  <a class="has-arrow" href="javascript:;">
                      <div class="parent-icon"><i class="bi bi-bookmark-star"></i>
                      </div>
                      <div class="menu-title">Manage Contact</div>
                  </a>
                  <ul>
                    @can('All Contact Messages')
                      <li class="{{ request()->routeIs('contactInquiries.*') ? 'mm-active' : '' }}"> <a
                              href="{{ route('contactInquiries.index') }}"><i
                                  class="bi bi-arrow-right-short"></i>Contact Inquiries</a>
                      </li>
                      @endcan
                      <li class="{{ request()->routeIs('quotations.*') ? 'mm-active' : '' }}"> <a
                              href="{{ route('quotations.index') }}"><i
                                  class="bi bi-arrow-right-short"></i>Quotations</a>
                      </li>
                      @can('All Contact Settings')
                      <li class="{{ request()->routeIs('contactUs.*') ? 'mm-active' : '' }}"> <a
                              href="{{ route('contactUs.index') }}"><i class="bi bi-arrow-right-short"></i>Contact
                              Setting</a>
                      </li>
                      @endcan
                      {{--                       <li class="{{ request()->routeIs('messagings.*') ? 'mm-active' : '' }}"> <a
                              href="{{ route('messagings.index') }}"><i class="bi bi-arrow-right-short"></i>Messaging</a>
                      </li> --}}
                  </ul>
              </li>
            @endif
            {{--             @if(auth()->user()->role->hasAnyDirectPermission(['All Blog Categories', 'All Blog Tags', ' All Blogs']))
              <li class="{{ request()->routeIs('blogs.*', 'tags.*', 'blogCategories.*') ? 'mm-active' : '' }}">
                  <a class="has-arrow" href="javascript:;">
                      <div class="parent-icon"><i class="bi bi-card-checklist"></i>
                      </div>
                      <div class="menu-title">Blogs</div>
                  </a>
                  <ul>
                    @can('All Blogs')
                      <li class="{{ request()->routeIs('blogs.*') ? 'mm-active' : '' }}"> <a
                              href="{{ route('blogs.index') }}"><i class="bi bi-arrow-right-short"></i>All Blog</a>
                      </li>
                    @endcan
                    @can('All Blog Categories')
                      <li class="{{ request()->routeIs('blogCategories.*') ? 'mm-active' : '' }}"> <a
                              href="{{ route('blogCategories.index') }}"><i
                                  class="bi bi-arrow-right-short"></i>Category</a>
                      </li>
                    @endcan
                    @can('All Blog Tags')
                      <li class="{{ request()->routeIs('tags.*') ? 'mm-active' : '' }}"> <a
                              href="{{ route('tags.index') }}"><i class="bi bi-arrow-right-short"></i>Blog Tags</a>
                      </li>
                    @endcan
                  </ul>
              </li>
              @endif --}}
            @if(auth()->user()->role->hasAnyDirectPermission(['All Roles', 'All Users']))
              <li class="{{ request()->routeIs('roles.*', 'users.*') ? 'mm-active' : '' }}">
                  <a class="has-arrow" href="javascript:;">
                      <div class="parent-icon"><i class="bi bi-person"></i>
                      </div>
                      <div class="menu-title">User Management</div>
                  </a>
                  <ul>
                    @can('All Roles')
                      <li class="{{ request()->routeIs('roles.*') ? 'mm-active' : '' }}"> <a
                              href="{{ route('roles.index') }}"><i class="bi bi-arrow-right-short"></i>Role</a>
                      </li>
                    @endcan
                    @can('All Users')
                      <li class="{{ request()->routeIs('users.*') ? 'mm-active' : '' }}"> <a
                              href="{{ route('users.index') }}"><i class="bi bi-arrow-right-short"></i>Users</a>
                      </li>
                    @endcan
                  </ul>
              </li>
              @endif
            @if(auth()->user()->role->hasAnyDirectPermission(['All Our Core Values', 'All Our Mission', 'All Our Vision']))
              <li
                  class="{{ request()->routeIs('ourCoreValues.*', 'ourMissions.*', 'ourVisions.*', 'stats.*') ? 'mm-active' : '' }}">
                  <a class="has-arrow" href="javascript:;">
                      <div class="parent-icon"><i class="bi bi-gear-wide"></i>
                      </div>
                      <div class="menu-title">About Settings</div>
                  </a>
                  <ul>
                      <li class="{{ request()->routeIs('aboutUs.*') ? 'mm-active' : '' }}"> <a
                              href="{{ route('aboutUs.index') }}"><i class="bi bi-arrow-right-short"></i>About Us</a></li>
                      <li class="{{ request()->routeIs('leadership-messages.*') ? 'mm-active' : '' }}"> <a
                              href="{{ route('leadership-messages.index') }}"><i class="bi bi-arrow-right-short"></i>Leadership Messages</a></li>       
                      <li class="{{ request()->routeIs('iot.*') ? 'mm-active' : '' }}"> <a
                              href="{{ route('iot.index') }}"><i class="bi bi-arrow-right-short"></i>IOT Section</a></li>       
                      <li class="{{ request()->routeIs('stats.*') ? 'mm-active' : '' }}"> <a
                              href="{{ route('stats.index') }}"><i class="bi bi-arrow-right-short"></i>Stats</a></li>       
                      <li class="{{ request()->routeIs('milestones.*') ? 'mm-active' : '' }}"> <a
                              href="{{ route('milestones.index') }}"><i class="bi bi-arrow-right-short"></i>Milestones</a></li> 
                    @can('All Our Mission')
                      <li class="{{ request()->routeIs('ourMissions.*') ? 'mm-active' : '' }}"> <a
                              href="{{ route('ourMissions.index') }}"><i class="bi bi-arrow-right-short"></i>Our
                              Mission</a></li>
                    @endcan
                    @can('All Our Vision')
                      <li class="{{ request()->routeIs('ourVisions.*') ? 'mm-active' : '' }}"> <a
                              href="{{ route('ourVisions.index') }}"><i class="bi bi-arrow-right-short"></i>Our
                              Vision</a></li>
                    @endcan
                      <li class="{{ request()->routeIs('brands.*') ? 'mm-active' : '' }}"> <a
                              href="{{ route('brands.index') }}"><i class="bi bi-arrow-right-short"></i>Brands</a></li>
                  </ul>
              </li>
              @endif
            @if(auth()->user()->role->hasAnyDirectPermission(['All Slider Settings', 'All Choose Us', 'All Home Settings']))
              <li
                  class="{{ request()->routeIs('homeSettings.*', 'sliders.*') ? 'mm-active' : '' }}">
                  <a class="has-arrow" href="javascript:;">
                      <div class="parent-icon"><i class="bi bi-gear-wide"></i>
                      </div>
                      <div class="menu-title">Home Settings</div>
                  </a>
                  <ul>

                      
                  @can('All Home Settings')
                      <li class="{{ request()->routeIs('homeSettings.*') ? 'mm-active' : '' }}"> <a
                              href="{{ route('homeSettings.index') }}"><i class="bi bi-arrow-right-short"></i>Home
                              Settings</a></li>
                              @endcan
                             
                              @can('All Slider Settings')
                      <li class="{{ request()->routeIs('sliders.*') ? 'mm-active' : '' }}"> <a
                              href="{{ route('sliders.index') }}"><i class="bi bi-arrow-right-short"></i>Sliders</a></li>
                              @endcan
                  </ul>
              </li>
              @endif
            @if(auth()->user()->role->hasAnyDirectPermission(['All General Settings', 'All Social Links', 'All Language Settings', 'All Concern Company', 'All Privacy Policy']))
              <li
                  class="{{ request()->routeIs('generalSettings.*', 'socialLinks.*', 'languages.*', 'branches.*','privacyPolicies.*') ? 'mm-active' : '' }}">
                  <a href="javascript:;" class="has-arrow">
                      <div class="parent-icon"><i class="bi bi-gear"></i>
                      </div>
                      <div class="menu-title">Settings</div>
                  </a>
                  <ul>
                    @can('All General Settings')
                      <li class="{{ request()->routeIs('generalSettings.*') ? 'mm-active' : '' }}"> <a
                              href="{{ route('generalSettings.index') }}"><i
                                  class="bi bi-arrow-right-short"></i>General Settings</a></li>
                    @endcan
                    @can('All Social Links')
                      <li class="{{ request()->routeIs('socialLinks.*') ? 'mm-active' : '' }}"> <a
                              href="{{ route('socialLinks.index') }}"><i class="bi bi-arrow-right-short"></i>Social
                              Link
                          </a></li>
                    @endcan
{{--                     @can('All Language Settings')
                      <li class="{{ request()->routeIs('languages.*') ? 'mm-active' : '' }}"> <a
                              href="{{ route('languages.index') }}"><i
                                  class="bi bi-arrow-right-short"></i>Language</a>
                      </li>
                      @endcan --}}
                      @can('All Concern Company')
                      <li class="{{ request()->routeIs('branches.*') ? 'mm-active' : '' }}"> <a
                              href="{{ route('branches.index') }}"><i class="bi bi-arrow-right-short"></i>Concern
                              Company</a></li>
                       @endcan
                       {{--                        @can('All Privacy Policy')
                      <li class="{{ request()->routeIs('privacyPolicies.*') ? 'mm-active' : '' }}"> <a
                              href="{{ route('privacyPolicies.index') }}"><i
                                  class="bi bi-arrow-right-short"></i>Privacy Policy</a></li>
                    @endcan --}}
                  </ul>
              </li>
              @endif



          </ul>
          <!--end navigation-->
      </aside>