<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ url("/images/logo.png")}}" class="logo" alt="Υδρόγειος">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
