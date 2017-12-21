<div class="btn-group" data-toggle="buttons">
    @foreach($options as $option => $label)
    <label class="btn btn-default btn-sm {{ \Request::get('order-pay-way', 'all') == $option ? 'active' : '' }}">
        <input type="radio" class="user-order-pay-way" value="{{ $option }}">{{$label}}
    </label>
    @endforeach
</div>