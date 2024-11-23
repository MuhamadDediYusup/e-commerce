@extends('backend.layouts.master')

@section('main-content')
    <div class="card">
        <h5 class="card-header">Tambah Produk</h5>
        <div class="card-body">
            <form method="post" action="{{ route('product.store') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Nama Produk <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="title" placeholder="Tambahkan nama produk"
                        value="{{ old('title') }}" class="form-control">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="summary" class="col-form-label">Rangkuman <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="summary" name="summary">{{ old('summary') }}</textarea>
                    @error('summary')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description" class="col-form-label">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="is_featured">Tersedia</label><br>
                    <input type="checkbox" name='is_featured' id='is_featured' value='1' checked> Ya
                </div>
                {{-- {{$categories}} --}}

                <div class="form-group">
                    <label for="category_id">Kategori <span class="text-danger">*</span></label>
                    <select name="category_id" id="category_id" class="form-control">
                        <option value="">--Pilih Kategori--</option>
                        @foreach ($categories as $key => $cat_data)
                            <option value='{{ $cat_data->id }}'>{{ $cat_data->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="price" class="col-form-label">Harga (IDR)<span class="text-danger">*</span></label>
                    <input id="price" type="number" name="price" placeholder="Tambahkan harga"
                        value="{{ old('price') }}" class="form-control">
                    @error('price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="discount" class="col-form-label">Diskon(%)</label>
                    <input id="discount" type="number" name="discount" min="0" max="100"
                        placeholder="Tambahkan Diskon(jika ada)" value="{{ old('discount') }}" class="form-control">
                    @error('discount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="stock">Jumlah <span class="text-danger">*</span></label>
                    <input id="quantity" type="number" name="stock" min="0" placeholder="Tambahkan jumlah"
                        value="{{ old('stock') }}" class="form-control">
                    @error('stock')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Foto <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                                <i class="fas fa-image"></i> Pilih
                            </a>
                        </span>
                        <input id="thumbnail" class="form-control" type="text" name="photo"
                            value="{{ old('photo') }}">
                    </div>
                    <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                    @error('photo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="weight" class="col-form-label">Berat (gram) <span class="text-danger">*</span></label>
                            <input id="weight" type="number" name="weight" placeholder="Tambahkan berat"
                                value="{{ old('weight') }}" class="form-control">
                            @error('weight')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="length" class="col-form-label">Panjang (cm) <span class="text-danger">*</span></label>
                            <input id="length" type="number" name="length" placeholder="Tambahkan panjang"
                                value="{{ old('length') }}" class="form-control">
                            @error('length')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="width" class="col-form-label">Lebar (cm) <span class="text-danger">*</span></label>
                            <input id="width" type="number" name="width" placeholder="Tambahkan lebar"
                                value="{{ old('width') }}" class="form-control">
                            @error('width')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="height" class="col-form-label">Tinggi (cm) <span class="text-danger">*</span></label>
                            <input id="height" type="number" name="height" placeholder="Tambahkan tinggi"
                                value="{{ old('height') }}" class="form-control">
                            @error('height')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
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
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <script>
        $('#lfm').filemanager('image');

        $(document).ready(function() {
            $('#summary').summernote({
                placeholder: "Tulis rangkuman.....",
                tabsize: 2,
                height: 100
            });
        });

        $(document).ready(function() {
            $('#description').summernote({
                placeholder: "Tulis deskripsi.....",
                tabsize: 2,
                height: 150
            });
        });
        // $('select').selectpicker();
    </script>
@endpush
