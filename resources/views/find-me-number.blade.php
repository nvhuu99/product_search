@if(session()->has('error'))
    <p style="padding: 5px; background-color:#f5f5f5;color:red">
        {{ session()->get('error') }}
    </p>
@endif

<p>
    Numbers: 0,1,2,3,4,5,6,7,8,9
</p>

<form action="">

    @csrf

    <p>
        <label for="">Find me number:</label>
        <input required type="text" placeholder="number..." value="{{ request()->input }}" name="input">
        <button> Try </button>

        @if(isset($yourNumber))
            <p>
                Is this your number? <span style="color:blue"> {{ $yourNumber }}</span>
                <br>
                <a href="{{ route('findMeNumber.confirm') }}">Yes</a>
                <br>
                <button> No please try again </button>
            </p>
        @endif
    </p>

</form>
