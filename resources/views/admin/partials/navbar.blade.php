<nav class="bg-blue-700 text-white shadow mb-6">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
        <div class="text-lg font-bold">
            MDRRMO Admin
        </div>
        <div class="space-x-4">
        <li>    <a href="{{ url('dashboard') }}" class="hover:underline">Dashboard</a>           </li>
        <li>    <a href="{{ url('/admin/posting') }}" class="hover:underline">Posting</a>           </li>
        <li>    <a href="{{ url('/admin/gps') }}" class="hover:underline">GPS Tracker</a>           </li>
        <li>    <a href="{{ url('/admin/ambulances') }}" class="hover:underline">Ambulances</a></li>
        <li>    <a href="{{ url('/admin/drivers') }}" class="hover:underline">Drivers</a>           </li>
        </div>
    </div>
</nav>
