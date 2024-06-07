@props(['taxi', 'colors'])

<div class="card">
    <div class="card-body">
        <h5 class="card-title">{{ $taxi->original->name }}</h5>
        <h6 class="card-subtitle mb-2 text-muted">{{ $taxi->price }} руб.</h6>
        <div>
            <p style="outline: 2px solid #000;height:20px;width:20px;background-color:{{ $taxi->color->name }}">
            </p>
        </div>
        <form action="{{ route('color.update', ['taxi' => $taxi->id]) }}" method="POST">
            @csrf
            @foreach ($colors as $color)
                <div>
                    <label>
                        <input type="radio" name="name" value={{$color->id}} {{ $taxi->color->name === $color->name ? 'checked' : '' }}>
                        {{$color->name}}
                    </label>
                </div>
            @endforeach

            <button class="btn btn-success" type="submit">Перекрасить</button>
            @if ($taxi->change_color == 0)
                Бесплатно
            @else
                1000 руб.
            @endif
        </form>


    </div>
</div>
