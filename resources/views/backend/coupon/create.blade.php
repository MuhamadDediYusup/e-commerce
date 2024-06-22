@extends('backend.layouts.master')

@section('main-content')
    <div class="card">
        <h5 class="card-header">Tambah Kupon</h5>
        <div class="card-body">
            <form method="post" action="{{ route('coupon.store') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Kode Kupon <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="code" placeholder="Tambahkan Kode Kupon"
                        value="{{ old('code') }}" class="form-control">
                    @error('code')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="type" class="col-form-label">Tipe <span class="text-danger">*</span></label>
                    <select name="type" class="form-control">
                        <option value="fixed">Tetap</option>
                        <option value="percent">Persentase</option>
                    </select>
                    @error('type')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Nilai <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="number" name="value" placeholder="Tambahkan Nilai"
                        value="{{ old('value') }}" class="form-control">
                    @error('value')
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
                placeholder: "Write short description.....",
                tabsize: 2,
                height: 150
            });
        });
    </script>
@endpush
