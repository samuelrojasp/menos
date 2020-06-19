<table class="table table-borderless table-condensed">
    <tr>
        <th class="pl-0">Productos:</th>
        <td>{{ format_price(Cart::total()) }}</td>
    </tr>
</table>

<h5>Total:</h5>
<h3>{{ format_price(Cart::total()) }}</h3>

<hr>
