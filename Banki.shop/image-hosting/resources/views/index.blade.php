@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Изображения</h1>
        <table>
            <thead>
                <tr>
                    <th>Название файла</th>
                    <th>Дата и время загрузки</th>
                    <th>Превью</th>
                    <th>Скачать</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($images as $image)
                    <tr>
                        <td>{{ $image->filename }}</td>
                        <td>{{ $image->upload_time }}</td>
                        <td><img src="{{ Storage::url('public/images/' . $image->filename) }}" alt="{{ $image->filename }}"
                                width="100"></td>
                        <td><a href="{{ Storage::url('public/images/' . $image->filename) }}" download>Скачать</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
