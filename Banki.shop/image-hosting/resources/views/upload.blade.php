@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Загрузить изображения</h1>
        <form action="{{ route('images.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" name="images[]" multiple accept="image/*">
            <button type="submit">Загрузить</button>
        </form>
    </div>
@endsection
