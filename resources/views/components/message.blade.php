@if (session('success'))
<div id="alert" class="flex items-center justify-between bg-green-500 text-white text-sm font-bold px-4 py-3 rounded relative" role="alert">
    <span>{{ session('success') }}</span>
    <button type="button" class="text-white" onclick="document.getElementById('alert').remove();">&times;</button>
</div>
@endif

@if (session('error'))
<div id="alert" class="flex items-center justify-between bg-red-500 text-white text-sm font-bold px-4 py-3 rounded relative" role="alert">
    <span>{{ session('error') }}</span>
    <button type="button" class="text-white" onclick="document.getElementById('alert').remove();">&times;</button>
</div>
@endif

@if (session('warning'))
<div id="alert" class="flex items-center justify-between bg-yellow-500 text-white text-sm font-bold px-4 py-3 rounded relative" role="alert">
    <span>{{ session('warning') }}</span>
    <button type="button" class="text-white" onclick="document.getElementById('alert').remove();">&times;</button>
</div>
@endif

@if (session('info'))
<div id="alert" class="flex items-center justify-between bg-blue-500 text-white text-sm font-bold px-4 py-3 rounded relative" role="alert">
    <span>{{ session('info') }}</span>
    <button type="button" class="text-white" onclick="document.getElementById('alert').remove();">&times;</button>
</div>
@endif
