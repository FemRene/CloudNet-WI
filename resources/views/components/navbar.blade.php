@if(session('cloudnet_logged_in'))
    <button type="button" class="btn btn-text max-sm:btn-square sm:hidden" aria-haspopup="dialog" aria-expanded="false" aria-controls="multilevel-with-separator" data-overlay="#multilevel-with-separator" >
        <span class="icon-[tabler--menu-2] size-5"></span>
    </button>

    <aside id="multilevel-with-separator" class="overlay [--auto-close:sm] overlay-open:translate-x-0 drawer drawer-start hidden max-w-64 sm:absolute sm:z-0 sm:flex sm:translate-x-0 sm:shadow-none" tabindex="-1" >
        <div class="drawer-header">
            <div class="flex items-center gap-3">
                <a class="flex items-center gap-3" href="{{route('welcome')}}">
                    <img src="{{asset('logo.png')}}" alt="logo" class="size-20">
                    <h3 class="drawer-title text-xl font-semibold">CloudNet-WI</h3>
                </a>
            </div>
        </div>
        <div class="drawer-body px-2 pt-4">
            <ul class="menu space-y-0.5 p-0">
                <li>
                    <a href="{{route('index')}}">
                        <span class="icon-[tabler--home] size-5"></span>
                        Dashboard
                    </a>
                </li>
                <li class="space-y-0.5">
                    <a class="collapse-toggle collapse-open:bg-base-content/10" id="menu-app" data-collapse="#menu-app-collapse">
                        <span class="icon-[tabler--apps] size-5"></span>
                        Nodes
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon-[tabler--settings] size-5"></span>
                        Settings
                    </a>
                </li>
                <div class="divider text-base-content/50 py-6 after:border-0">Account</div>
                <li>
                    <a href="#">
                        <span class="icon-[tabler--login] size-5"></span>
                        Sign In
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon-[tabler--logout-2] size-5"></span>
                        Sign Out
                    </a>
                </li>
                <div class="divider text-base-content/50 py-6 after:border-0">Miscellaneous</div>
                <li>
                    <a href="#">
                        <span class="icon-[tabler--users-group] size-5"></span>
                        Support
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon-[tabler--files] size-5"></span>
                        Documentation
                    </a>
                </li>
            </ul>
        </div>
    </aside>
@else
    <nav class="navbar rounded-box flex w-full items-center justify-between gap-2 shadow-base-300/20 shadow-sm">
        <div class="navbar-start max-md:w-1/4">
            <a class="flex items-center gap-3" href="{{route('welcome')}}">
                <img src="{{asset('logo.png')}}" alt="logo" class="size-20">
                <h3 class="drawer-title text-xl font-semibold">CloudNet-WI</h3>
            </a>
        </div>
        <a class="btn max-md:btn-square btn-primary" href="{{route('login.form')}}">
            <span class="max-md:hidden">Get started</span>
            <span class="icon-[tabler--arrow-right] rtl:rotate-180"></span>
        </a>
    </nav>
@endif
