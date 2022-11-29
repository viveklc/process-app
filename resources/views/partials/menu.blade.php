<!--begin::Sidebar-->
<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Logo-->
    <div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
       <!--begin::Logo image-->
       <a href="#">
       <img alt="Logo" src="{{ asset('media/logos/default-dark.svg') }}" class="h-25px app-sidebar-logo-default" />
       <img alt="Logo" src="{{ asset('media/logos/default-small.svg') }}" class="h-20px app-sidebar-logo-minimize" />
       </a>
       <!--end::Logo image-->
       <!--begin::Sidebar toggle-->
       <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary body-bg h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
          <!--begin::Svg Icon | path: icons/duotune/arrows/arr079.svg-->
          <span class="svg-icon svg-icon-2 rotate-180">
             <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path opacity="0.5" d="M14.2657 11.4343L18.45 7.25C18.8642 6.83579 18.8642 6.16421 18.45 5.75C18.0358 5.33579 17.3642 5.33579 16.95 5.75L11.4071 11.2929C11.0166 11.6834 11.0166 12.3166 11.4071 12.7071L16.95 18.25C17.3642 18.6642 18.0358 18.6642 18.45 18.25C18.8642 17.8358 18.8642 17.1642 18.45 16.75L14.2657 12.5657C13.9533 12.2533 13.9533 11.7467 14.2657 11.4343Z" fill="currentColor" />
                <path d="M8.2657 11.4343L12.45 7.25C12.8642 6.83579 12.8642 6.16421 12.45 5.75C12.0358 5.33579 11.3642 5.33579 10.95 5.75L5.40712 11.2929C5.01659 11.6834 5.01659 12.3166 5.40712 12.7071L10.95 18.25C11.3642 18.6642 12.0358 18.6642 12.45 18.25C12.8642 17.8358 12.8642 17.1642 12.45 16.75L8.2657 12.5657C7.95328 12.2533 7.95328 11.7467 8.2657 11.4343Z" fill="currentColor" />
             </svg>
          </span>
          <!--end::Svg Icon-->
       </div>
       <!--end::Sidebar toggle-->
    </div>
    <!--end::Logo-->
    <!--begin::sidebar menu-->
    <div class="app-sidebar-menu overflow-hidden flex-column-fluid">
       <!--begin::Menu wrapper-->
       <div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
          <!--begin::Menu-->
          <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">
            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link  {{ request()->is("admin/dashboard*") ? 'active' : '' }}" href="{{ url('admin/dashboard') }}">
                <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Dashboard</span>
                </a>
                <!--end:Menu link-->
            </div>
            <!--end:Menu item-->

            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link  {{ request()->is("admin/users*") ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Users</span>
                </a>
                <!--end:Menu link-->
            </div>
            <!--end:Menu item-->

            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link  {{ request()->is("admin/permissions*") ? 'active' : '' }}" href="{{ route('admin.permissions.index') }}">
                <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Permissions</span>
                </a>
                <!--end:Menu link-->
            </div>
            <!--end:Menu item-->

            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link  {{ request()->is("admin/roles*") ? 'active' : '' }}" href="{{ route('admin.roles.index') }}">
                <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Roles</span>
                </a>
                <!--end:Menu link-->
            </div>
            <!--end:Menu item-->

            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link  {{ request()->is("admin/plans*") ? 'active' : '' }}" href="{{ route('admin.plans.index') }}">
                <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Plans</span>
                </a>
                <!--end:Menu link-->
            </div>
            <!--end:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link  {{ request()->is("admin/processes*") ? 'active' : '' }}" href="{{ route('admin.processes.index') }}">
                <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Processes</span>
                </a>
                <!--end:Menu link-->
            </div>
            <!--end:Menu item-->


            <!--begin:Menu item-->
             <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link  {{ request()->is("admin/countries*") ? 'active' : '' }}" href="{{ route('admin.countries.index') }}">
                <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Countries</span>
                </a>
                <!--end:Menu link-->
             </div>
            <!--end:Menu item-->

            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link  {{ request()->is("admin/team*") ? 'active' : '' }}" href="{{ route('admin.team.index') }}">
                <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Teams</span>
                </a>
                <!--end:Menu link-->
             </div>
            <!--end:Menu item-->

            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link  {{ request()->is("admin/states*") ? 'active' : '' }}" href="{{ route('admin.states.index') }}">
                <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">States</span>
                </a>
                <!--end:Menu link-->
             </div>
            <!--end:Menu item-->

            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link  {{ request()->is("admin/cities*") ? 'active' : '' }}" href="{{ route('admin.cities.index') }}">
                <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Cities</span>
                </a>
                <!--end:Menu link-->
             </div>
            <!--end:Menu item-->

            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link  {{ request()->is("admin/organizations*") ? 'active' : '' }}" href="{{ route('admin.organizations.index') }}">
                <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Organizations</span>
                </a>
                <!--end:Menu link-->
             </div>
            <!--end:Menu item-->

            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link  {{ request()->is("admin/subjects*") ? 'active' : '' }}" href="{{ route('admin.subjects.index') }}">
                <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Subjects</span>
                </a>
                <!--end:Menu link-->
             </div>
            <!--end:Menu item-->

            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link  {{ request()->is("admin/schools*") ? 'active' : '' }}" href="{{ route('admin.schools.index') }}">
                <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Schools</span>
                </a>
                <!--end:Menu link-->
             </div>
            <!--end:Menu item-->

            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link  {{ request()->is("admin/courses*") ? 'active' : '' }}" href="{{ route('admin.courses.index') }}">
                <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Courses</span>
                </a>
                <!--end:Menu link-->
             </div>
            <!--end:Menu item-->

            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link  {{ request()->is("admin/levels*") ? 'active' : '' }}" href="{{ route('admin.levels.index') }}">
                <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Levels</span>
                </a>
                <!--end:Menu link-->
             </div>
            <!--end:Menu item-->

            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link  {{ request()->is("admin/classes*") ? 'active' : '' }}" href="{{ route('admin.classes.index') }}">
                <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Classes</span>
                </a>
                <!--end:Menu link-->
             </div>
            <!--end:Menu item-->

            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link  {{ request()->is("admin/departments*") ? 'active' : '' }}" href="{{ route('admin.departments.index') }}">
                <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Departments</span>
                </a>
                <!--end:Menu link-->
             </div>
            <!--end:Menu item-->

            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link  {{ request()->is("admin/pages*") ? 'active' : '' }}" href="{{ route('admin.pages.index') }}">
                <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Pages</span>
                </a>
                <!--end:Menu link-->
             </div>
            <!--end:Menu item-->

            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link  {{ request()->is("admin/chapters*") ? 'active' : '' }}" href="{{ route('admin.chapters.index') }}">
                <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Chapters</span>
                </a>
                <!--end:Menu link-->
             </div>
            <!--end:Menu item-->

            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link  {{ request()->is("admin/books*") ? 'active' : '' }}" href="{{ route('admin.books.index') }}">
                <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Books</span>
                </a>
                <!--end:Menu link-->
             </div>
            <!--end:Menu item-->

            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link  {{ request()->is("admin/tags*") ? 'active' : '' }}" href="{{ route('admin.tags.index') }}">
                <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Tags</span>
                </a>
                <!--end:Menu link-->
             </div>
            <!--end:Menu item-->

            <!--begin:Menu item-->
            <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link  {{ request()->is("admin/orgs*") ? 'active' : '' }}" href="{{ route('admin.orgs.index') }}">
                <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Orgs</span>
                </a>
                <!--end:Menu link-->
             </div>
            <!--end:Menu item-->

            <!--begin:Menu item-->
             <div class="menu-item">
                <!--begin:Menu link-->
                <a class="menu-link  {{ request()->is("admin/depts*") ? 'active' : '' }}" href="{{ route('admin.depts.index') }}">
                <span class="menu-bullet">
                <span class="bullet bullet-dot"></span>
                </span>
                <span class="menu-title">Depts</span>
                </a>
                <!--end:Menu link-->
             </div>
            <!--end:Menu item-->

          </div>
          <!--end::Menu-->
       </div>
       <!--end::Menu wrapper-->
    </div>
    <!--end::sidebar menu-->

 </div>
 <!--end::Sidebar-->
