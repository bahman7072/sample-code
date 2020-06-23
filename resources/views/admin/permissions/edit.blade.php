@component('admin.layouts.content', ['title' => 'ویرایش دسترسی'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">داشبورد</a></li>
        <li class="breadcrumb-item"><a href="{{ route('permissions.index') }}">دسترسی ها</a></li>
        <li class="breadcrumb-item active">ویرایش دسترسی</li>
    @endslot

    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">فرم ویرایش دسترسی</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form method="post" action="{{ route('permissions.update', ['permission' => $permission->id]) }}" class="form-horizontal">
                    @csrf
                    @method('PATCH')

                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8 offset-lg-2">
                                <div class="form-group">
                                    <label for="name" class="col-sm-3 control-label">عنوان دسترسی</label>
                                    <input type="text" name="name" value="{{ old('name', $permission->name) }}" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="عنوان دسترسی را وارد کنید">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-8 offset-lg-2">
                                <div class="form-group">
                                    <label for="label" class="col-sm-3 control-label">توضیح دسترسی</label>
                                    <input type="text" name="label" value="{{ old('label', $permission->label) }}" class="form-control @error('label') is-invalid @enderror" id="label" placeholder="توضیح دسترسی را وارد کنید">
                                    @error('label')
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
                        <button type="submit" class="btn btn-primary">ویرایش</button>
                        <a href="{{ route('permissions.index') }}" class="btn btn-default float-left">لغو</a>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
@endcomponent