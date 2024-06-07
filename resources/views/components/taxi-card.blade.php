{{-- <style>
    .color-option {
        display: inline-block;
        width: 20px;
        height: 20px;
        margin-right: 5px;
        vertical-align: middle;
    }
</style> --}}

<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ $taxi->name }}</h5>
        <h6 class="card-subtitle mb-2 text-muted">{{ $taxi->price }} руб.</h6>
        <form action="{{ route('taxi.buy', ['taxi' => $taxi->id]) }}" method="POST">
            @csrf
            <div>
               <p style="outline: 2px solid #000;height:20px;width:20px;background-color:{{$taxi->color->name}}"></p> 
            </div>

            <input type="hidden" name="taxi_id" value="{{ $taxi->id }}">
            <button type="submit" class="btn btn-primary">Купить</button>
        </form>
    </div>
</div>
