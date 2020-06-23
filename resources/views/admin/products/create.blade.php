@component('admin.layouts.content', ['title' => 'ایجاد محصول'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">داشبورد</a></li>
        <li class="breadcrumb-item"><a href="{{ route('products.index') }}">لیست محصولات</a></li>
        <li class="breadcrumb-item active">ایجاد محصول</li>
    @endslot

    @slot('script')
        <script>
            $(document).ready(function () {
                var $searchfield = $(this).find('.select2-search__field');
                $searchfield.css('border', 'none');
            });

            $('#categories').select2({
                placeholder: 'دسترسی مورد نظر را انتخاب کنید'
            });
        </script>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">ایجاد محصول</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post" action="{{ route('products.store') }}" class="form-horizontal">
                    @csrf

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">
                                <div class="form-group">
                                    <label for="title" class="col-sm-2 control-label">عنوان</label>
                                    <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="نام محصول را وارد کنید" value="{{ old('title') }}">
                                    @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-8 offset-lg-2">
                                <div class="form-group">
                                    <label for="description" class="col-sm-2 control-label">توضیحات محصول</label>
                                    <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror" id="description" placeholder="توضیحات محصول را وارد کنید">{{ old('description') }}</textarea>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-8 offset-lg-2">
                                <div class="form-group">
                                    <label for="price" class="col-sm-2 control-label">قیمت</label>
                                    <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" id="price" placeholder="قیمت محصول را وارد کنید" value="{{ old('price') }}">
                                     @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-8 offset-lg-2">
                                <div class="form-group">
                                    <label for="inventory" class="col-sm-3 control-label">تعداد مجودی</label>
                                    <input type="number" name="inventory" class="form-control" id="inventory" placeholder="مجودی محصول را وارد کنید" value="{{ old('inventory') }}">
                                    @error('inventory')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-8 offset-lg-2">
                                <div class="form-group">
                                    <label for="categories" class="col-sm-3 control-label">دسته</label>
                                    <select class="form-control @error('categories') is-invalid @enderror" name="categories[]" id="categories" multiple>
                                        @foreach(\App\Category::all() as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('categories')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">ایجاد</button>
                        <a href="{{ route('products.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endcomponent