@extends('dashboard.master')
@section('title', __('messages.brand'))

@section('content')

<div class="container mt-2">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                {{-- <h2>Laravel 9 CRUD Example</h2> --}}
            </div>
            <div class="pull-right mb-2">
                <a class="btn btn-success" href="{{ route('brands.create') }}"> Create Student</a>
            </div>
        </div>
    </div>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>S.No</th>
                <th>Student Name</th>
                <th>Student Email</th>
                <th>Student Address</th>
                <th width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($brands as $student)
                <tr>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->email }}</td>
                    <td>{{ $student->address }}</td>
                    <td>
                        <form action="{{ route('brands.destroy',$student->id) }}" method="Post">
                            <a class="btn btn-primary" href="{{ route('brands.edit',$student->id) }}">Edit</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
        </tbody>
    </table>
    {!! $brands->links() !!}
</div>


@endsection
