<x-app-layout>
    <div class="wrapper">
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Product Creation</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Create Product</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- left column -->
                        <div class="col-md-12">
                            <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Create Product</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form action="{{ route('products.create') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="form-group">
                                                            <label>Title</label>
                                                            <input type="text" class="form-control" name="title"
                                                                placeholder="Enter Title">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Product Code</label>
                                                            <input type="text" class="form-control" name="product_code"
                                                                placeholder="Product Code">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Price</label>
                                                            <input type="text" class="form-control" name="price"
                                                                placeholder="Price">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Designer</label>
                                                            <input type="text" class="form-control" name="designer_name"
                                                                placeholder="Designer">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="form-group">
                                                            <label>Description</label>
                                                            <textarea id="summernote" name="description">
                                                            Description <em>goes</em> <strong>here...</strong>
                                                        </textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="form-group">
                                                            <label>Short Description</label>
                                                            <textarea class="form-control" rows="3"
                                                                name="short_description"
                                                                placeholder="Enter Short Description..."></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label>Category</label>
                                                            <select name="category_id" class="form-control"
                                                                id="categorySelect">
                                                                <option value="">Select Category</option>
                                                                @foreach ($categories as $category)
                                                                <option value="{{ $category->id }}">{{ $category->name
                                                                    }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label>Sub-Category</label>
                                                            <select name="subcategory_id" class="form-control"
                                                                id="subcategorySelect">
                                                                <option value="">Select Sub-Category</option>
                                                                <!-- Subcategories will be populated dynamically -->
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Weight</label>
                                                            <input type="text" class="form-control" name="weight"
                                                                placeholder="Enter Weight">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Dimensions</label>
                                                            <input type="text" class="form-control" name="dimensions"
                                                                placeholder="Enter Dimensions">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Select Designs <small class="light">(jpg, jpeg, png, gif,
                                                            mp4, mkv, avi, stl, 3dm)</small></label>
                                                    <div class="input-group">
                                                        <div class="custom-file">
                                                            <input type="file" class="custom-file-input" name="files[]"
                                                                id="fileInput" multiple onchange="previewFiles(event)">
                                                            <label class="custom-file-label" for="fileInput">Choose
                                                                files</label>
                                                        </div>
                                                    </div>
                                                    <div class="mt-4">
                                                        <ul
                                                            class="mailbox-attachments d-flex align-items-stretch clearfix">
                                                            <span id="previewContainer"></span>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary float-right">Create
                                            Product</button>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                        <!--/.col (left) -->
                    </div>
                    <!-- /.row -->
                </div>
            </section>
            <!-- /.content -->
        </div>
    </div>

    <script>
        // JavaScript to populate subcategories based on category selection
        document.getElementById('categorySelect').addEventListener('change', function() {
            var categoryId = this.value;
            var subcategorySelect = document.getElementById('subcategorySelect');

            // Clear previous subcategories
            subcategorySelect.innerHTML = '<option value="">Select Sub-Category</option>';

            if (categoryId) {
                // Find the selected category from the categories array
                var category = @json($categories).find(function(cat) {
                    return cat.id == categoryId;
                });

                // If subcategories exist, populate the subcategory dropdown
                if (category && category.subcategories.length > 0) {
                    category.subcategories.forEach(function(subcategory) {
                        var option = document.createElement('option');
                        option.value = subcategory.id;
                        option.textContent = subcategory.name;
                        subcategorySelect.appendChild(option);
                    });
                }
            }
        });

        // Preview images on file selection
        // Preview images on file selection
        // Preview images on file selection
        function previewFiles(event) {
            const files = event.target.files;
            const previewContainer = document.getElementById('previewContainer');
            previewContainer.innerHTML = ""; // Clear previous previews

            if (files.length > 0) {
                Array.from(files).forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        // Create list item
                        const listItem = document.createElement('li');
                        listItem.classList.add('preview-item'); // Optional: for styling each preview item
                        listItem.style.position = 'relative'; // Make sure the list item is positioned relatively

                        // Create image container (span)
                        const imageContainer = document.createElement('span');
                        imageContainer.classList.add('mailbox-attachment-icon', 'has-img');
                        imageContainer.style.display = "inline-block"; // Ensure the span behaves like a block-level element
                        imageContainer.style.width = "100%"; // Set width for the span
                        imageContainer.style.height = "150px"; // Set height for the span
                        imageContainer.style.overflow = "hidden"; // Hide any overflow

                        // Create image preview
                        const imgPreview = document.createElement('img');
                        imgPreview.src = e.target.result;
                        imgPreview.alt = file.name;
                        imgPreview.style.width = "100%"; // Make the image fill the span width
                        imgPreview.style.height = "100%"; // Make the image fill the span height
                        imgPreview.style.objectFit = "cover"; // Ensure the image covers the span without distortion

                        imageContainer.appendChild(imgPreview);

                        // Create attachment info
                        const attachmentInfo = document.createElement('div');
                        attachmentInfo.classList.add('mailbox-attachment-info');

                        const fileName = document.createElement('a');
                        fileName.href = "#";
                        fileName.classList.add('mailbox-attachment-name');
                        fileName.innerHTML = `<i class="fas fa-camera"></i> Design_${index + 1}`;

                        const attachmentSize = document.createElement('span');
                        attachmentSize.classList.add('mailbox-attachment-size', 'clearfix', 'mt-1');
                        const sizeText = document.createElement('span');
                        const fileSize = (file.size / 1024 / 1024).toFixed(2) + ' MB';
                        sizeText.textContent = fileSize;

                        const mimeType = document.createElement('span');
                        mimeType.classList.add('mailbox-attachment-size', 'clearfix', 'mt-1');
                        const typeText = document.createElement('span');
                        const fileType = file.type;
                        typeText.textContent = fileType;

                        attachmentSize.appendChild(sizeText);
                        mimeType.appendChild(typeText);

                        attachmentInfo.appendChild(fileName);
                        attachmentInfo.appendChild(attachmentSize);
                        attachmentInfo.appendChild(mimeType);

                        // Add Close Button
                        const closeButton = document.createElement('span');
                        closeButton.classList.add('close-btn');
                        closeButton.innerHTML = '&times;';
                        closeButton.style.position = 'absolute';
                        closeButton.style.top = '5px';
                        closeButton.style.right = '5px';
                        closeButton.style.fontSize = '20px';
                        closeButton.style.color = '#ff0000';
                        closeButton.style.cursor = 'pointer';

                        // Add event listener to remove preview on close button click
                        closeButton.addEventListener('click', function() {
                            listItem.remove(); // Remove the preview item
                        });

                        // Append all to the list item
                        listItem.appendChild(imageContainer);
                        listItem.appendChild(attachmentInfo);
                        listItem.appendChild(closeButton); // Add the close button to the list item

                        previewContainer.appendChild(listItem);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }
    </script>
</x-app-layout>