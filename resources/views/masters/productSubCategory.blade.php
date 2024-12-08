<x-app-layout>
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Product Subcategories</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Product Subcategories</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <!-- Flash Messages -->
                    <!-- Flash Messages -->
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif


                    <div class="row">
                        <!-- Create Product Subcategory -->
                        <div class="col-md-6">
                            <div class="card card-warning">
                                <div class="card-header">
                                    <h3 class="card-title">Create New Product Subcategory</h3>
                                </div>
                                <form method="POST" action="{{ route('productSubCategories.store') }}">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Category</label>
                                            @if($categories->isEmpty())
                                            <p class="text-danger">No categories available. Please add categories first.</p>
                                            @else
                                            <select name="category_id" class="form-control">
                                                <option value="">Select Category</option>
                                                @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label>Subcategory Name</label>
                                            <input type="text" name="name" class="form-control" placeholder="Enter Subcategory Name" value="{{ old('name') }}">
                                            @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label>Code</label>
                                            <input type="text" name="code" class="form-control" placeholder="Enter Code" value="{{ old('code') }}">
                                            @error('code')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- List of Product Subcategories -->
                        <div class="col-md-6">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Product Subcategories List</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Subcategory Name</th>
                                                <th>Category</th>
                                                <th>Code</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($subcategories->isEmpty())
                                            <tr>
                                                <td colspan="5" class="text-center text-muted">No subcategories found.</td>
                                            </tr>
                                            @else
                                            @foreach($subcategories as $index => $subcategory)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $subcategory->name }}</td>
                                                <td>{{ $subcategory->category->name ?? 'No category' }}</td>
                                                <td>{{ $subcategory->code }}</td>
                                                <!-- <td>
                                                    <form action="{{ route('productSubCategories.destroy', $subcategory->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this subcategory?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                </td> -->
                                                <td>
                                                    <a href="{{ route('productSubCategories.edit', $subcategory->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                    <form method="POST" action="{{ route('productSubCategories.destroy', $subcategory->id) }}" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                    </form>
                                                </td>

                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</x-app-layout>
