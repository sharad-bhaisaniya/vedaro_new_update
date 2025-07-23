@props(['url'])
<tr>
<td class="header" style="background-color: #4CAF50; padding: 10px;">
<a href="{{ $url }}" style="display: inline-block; color: #fff;">
@if (trim($slot) === 'Laravel')
<img src="{{ asset('assets/images/black.png') }}" alt=""> 
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
