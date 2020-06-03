@component('mail::message')
{{-- Greeting --}}

# @lang('Transacción Realizada')


<table class="table">
<tr>
<th>Código de la transacción</th>
<td>{{ $transaccion->encoded_id }}</td>
</tr>

<tr>
<th>Cuenta Abono</th>
<td>{{ $transaccion->cuenta_abono }}</td>
</tr>
<tr>
<th>Nombre</th>
<td>{{ $transaccion->nombre_abono }}</td>
</tr>

<tr>
<th>Cuenta Cargo</th>
<td>{{ $transaccion->cuenta_cargo }}</td>
</tr>
<tr>
<th>Nombre</th>
<td>{{ $transaccion->nombre_cargo }}</td>
</tr>

<tr>
<th>Glosa</th>
<td>{{ $transaccion->glosa }}</td>
</tr>

<tr>
<th>Importe</th>
<td>{{ number_format($transaccion->importe,0,',','.') }}</td>
</tr>
<tr>
<th>Fecha Transaccion</th>
<td>{{ $transaccion->created_at }}</td>
</tr>

</table>    



{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Regards'),<br>
{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
    "If you’re having trouble clicking the  button, copy and paste the URL below\n"
)
@endslot
@endisset
@endcomponent