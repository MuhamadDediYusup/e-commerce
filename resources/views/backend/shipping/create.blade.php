@extends('backend.layouts.master')

@section('main-content')
    <div class="card">
        <h5 class="card-header">Tambah Biaya Pengiriman</h5>
        <div class="card-body">
            <form method="post" action="{{ route('shipping.store') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Nama Jasa Pengiriman <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="name" placeholder="Tambahkan Jasa Pengiriman"
                        value="{{ old('type') }}" class="form-control">
                    @error('type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price" class="col-form-label">Harga <span class="text-danger">*</span></label>
                    <input id="price" type="number" name="price" placeholder="Tambahkan harga"
                        value="{{ old('price') }}" class="form-control">
                    @error('price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-control">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button class="btn btn-success" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
    <script>
        $('#lfm').filemanager('image');

        $(document).ready(function() {
            $('#description').summernote({
                placeholder: "Tulis deskripsi.....",
                tabsize: 2,
                height: 150
            });
        });
    </script>
@endpush
