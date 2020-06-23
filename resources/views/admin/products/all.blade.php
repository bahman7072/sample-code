@component('admin.layouts.content', ['title' => 'محصولات'])
    @slot('breadcrumb')
        <li class="breadcrumb-item"><a href="/admin">داشبورد</a></li>
        <li class="breadcrumb-item active">لیست محصولات</li>
    @endslot

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">محصولات</h3>

                    <div class="card-tools d-flex">
                        <form action="">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <input type="text" name="search" class="form-control float-right" value="{{ request('search') }}" placeholder="جستجو">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                        <div class="btn-group-sm mr-2">
                            @can('create-product')
                                <a href="{{ route('products.create') }}" class="btn btn-info">ایجاد <i class="fa fa-plus"></i></a>
                            @endcan
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                        <tbody>
                        <tr>
                            <th>شماره</th>
                            <th>نام محصول</th>
                            <th>قیمت</th>
                            <th>موجودی</th>
                            <th>تعداد بازدید</th>
                            <th>اقدامات</th>
                        </tr>
                        @foreach($products as $product)
                            <tr>
                                <td>{{ $product->id }}</td>
                                <td>{{ $product->title }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->inventory }}</td>
                                <td>{{ $product->view_count }}</td>
                                <td>
                                    <div class="btn-group">
                                        @can('edit-product')
                                            <a href="{{ route('products.edit', ['product' => $product->id]) }}" class="btn btn-sm btn-primary" title="ویرایش"><i class="fa fa-edit"></i></a>
                                        @endcan
                                       @can('delete-product')
                                            <form action="{{ route('products.destroy', ['product' => $product->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="btn btn-sm btn-danger" title="حذف"><i class="fa fa-remove"></i></button>
                                            </form>
                                       @endcan
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <div class="col-lg-12 text-center">{{ $products->appends(['search' => request('search')])->render() }}</div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endcomponent