@extends('profile.layout')

@section('main')
    <h5 class="font-weight-bold">Two Factor Auth</h5>
    <hr>
    <form method="post" action="#">
        @csrf
        <div class="form-group">
            <label for="type">Type</label>
            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror">
                @foreach(config('twofactor.types') as $key => $name)
                    <option {{ old('type') == $key || auth()->user()->hasTwoFactor($key) ? 'selected' : '' }} value="{{ $key }}">{{ $name }}</option>
                @endforeach
            </select>
            @error('type')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <lable for="phone">Phone</lable>
            <input type="text" name="phone" id="phone" value="{{ old('phone') ?? auth()->user()->phone }}" class="form-control @error('phone') is-invalid @enderror">
            @error('phone')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
@endsection
