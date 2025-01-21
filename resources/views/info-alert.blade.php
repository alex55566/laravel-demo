@if(session()->has('success'))
<p class="alert success">{{ session()->get('success') }}</p>
@endif

@if(session()->has('warning'))
<p class="alert warning">{{ session()->get('warning') }}</p>
@endif