<x-app-layout>
    <div class="wrapper">
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title">Edit Product Category</h3>
                                </div>
                                <form method="POST" action="{{ route('productCategories.update', $category->id) }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Category Name</label>
                                            <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label>Code</label>
                                            <input type="text" name="code" class="form-control" value="{{ old('code', $category->code) }}">
                                            @error('code')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
