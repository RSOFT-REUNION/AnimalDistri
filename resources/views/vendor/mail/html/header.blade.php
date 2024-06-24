@props(['url'])
<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
<img src="http://augur.loc/images/logo/logo_gris.png" alt="Augur Logo">
@endif
</a>
</td>
</tr>
