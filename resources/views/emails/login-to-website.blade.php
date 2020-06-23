@component('mail::message')
    <h2>Welcome to Mibak Website</h2>
    @component('mail::button', ['url' => url('/')])
        وبسایت میباک
    @endcomponent
@endcomponent