<div class="navbar bg-base-100 shadow-sm">
    <div class="navbar-start">
        <div class="dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                </svg>
            </div>
            <ul tabindex="-1" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                <li><a>Item 1</a></li>
                <li>
                    <a>Parent</a>
                    <ul class="p-2">
                        <li><a>Submenu 1</a></li>
                        <li><a>Submenu 2</a></li>
                    </ul>
                </li>
                <li><a>Item 3</a></li>
            </ul>
        </div>
        <a class="btn btn-ghost text-xl" href="/">Attendance System</a>
    </div>
    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1">
            <li><a href="{{ route('devices.index') }}">Device</a></li>
            <li>
                <details>
                    <summary>Registration</summary>
                    <ul class="p-2">
                        <li><a href="{{ route('students.index') }}">Students</a></li>
                        <li><a href="#">Teacher</a></li>
                    </ul>
                </details>
            </li>
            <li>
                <details>
                    <summary>Reports</summary>
                    <ul class="p-2">
                        <li><a href="{{ route('attendance.daily') }}">Daily</a></li>
                    </ul>
                </details>
            </li>
        </ul>
    </div>
    <div class="navbar-end">
        <div class="flex items-center gap-4">
            <div class="navbar-end">
                <button id="theme-toggle" class="btn btn-ghost btn-circle">
                    <span id="icon-light">🌞</span>
                    <span id="icon-dark" class="hidden">🌙</span>
                </button>
            </div>
            <a class="btn btn-sm btn-secondary">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-log-out-icon lucide-log-out">
                    <path d="m16 17 5-5-5-5" />
                    <path d="M21 12H9" />
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                </svg></a>
        </div>
    </div>
</div>
