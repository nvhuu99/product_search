    'sort',
<form>
    @csrf

    <p for=""><b>Product Filters:</b></p>
    <p for="">
        Search by name:
        <input type="text" name="search" value="{{ request()->search }}">
    </p>
    <p for="">
        Min price:
        <input type="number" name="min_price" value="{{ request()->min_price }}">
    </p>
    <p for="">
        Max price:
        <input type="number" name="max_price" value="{{ request()->max_price }}">
    </p>
    <p for="">
        By categories:
        <span>
            {{ request()->category_name ?? request()->category_id ?? 'Not selected' }}
        </span>
        <a href="{{ route('category.list') }}"><i>All category</i></a>
    </p>

    <p for="">
        <button>
            <a href=" {{ route('product.list', array_merge(request()->query(), ['sort' => 'popular']) ) }}"> Popular products </a>
        </button>
    </p>

    <button type="submit">Submit</button>

</form>

<div>
    @foreach ($products as $p)
        <div style="
                width: 300px;
                margin-bottom: 16px;
                padding: 10px;
                border-radius: 5px;
                background-color: rgb(226 226 226 / 53%);
            ">
            <span> <b>{{ $p->name }}</b> </h4>
            <br>
            <span style="color: red">
                Price: {{ number_format(min($p->unit_price, $p->discount_price)) . ' VND' }}
            </span>
            <br>
            <span style="color: blue"> Category: {{ $p->category_name }}</span>
            <br>
            <span> {{ substr($p->short_description, 0, 85) . '...' }}</span>
            <br>
            <span style="color: orange">
                View: {{ $p->views }} | Sales: {{ $p->sales }} | Rating: {{ $p->avg_rating }}
            </span>
        </div>
    @endforeach
</div>