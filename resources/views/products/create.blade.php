@extends('layouts.app')

@section('content')
<style>
    .image-wrapper {
        position: relative;
        box-shadow: 0 4px 4px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        overflow: hidden;
        transition: transform 0.2s;
    }

    .image-wrapper:hover {
        transform: translateY(-5px);
    }

    .image-wrapper img {
        border-radius: 10px;
        object-fit: cover;
        width: 100%;
        height: 150px;
    }

    .image-wrapper .btn-secondary {
        display: none;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 40px;
        height: 40px;
        padding: 0;
        font-size: 1.5rem;
        border: none;
        border-radius: 50%;
        color: white;
    }

    .image-wrapper:hover .btn-secondary {
        display: block;
    }

    .image-wrapper:hover::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 10px;
    }
</style>

<div class="container mt-5">
    <h1>Add New Product</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form id="product-form" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" id="price" name="price" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="stitch" class="form-label">Stitch</label>
            <input type="text" class="form-control" id="stitch" name="stitch" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="images" class="form-label">Product Images</label>
            <input type="file" class="form-control" id="images" name="images[]" multiple required>
            <div id="image-preview" class="row mt-3"></div>
        </div>
        <button type="submit" class="btn btn-primary">Add Product</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let filesToUpload = [];

        $('#images').on('change', function() {
            $('#image-preview').empty(); // Clear previous previews

            filesToUpload = Array.from(this.files); // Update the files to upload

            const files = this.files;
            if (files) {
                $.each(files, function(index, file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const colDiv = $('<div>').addClass('col-md-3 position-relative mb-3').attr('id', 'image-preview-' + index);
                        const imageWrapper = $('<div>').addClass('image-wrapper');
                        const imgElement = $('<img>').attr('src', e.target.result);
                        const removeButton = $('<button>')
                            .addClass('btn btn-secondary')
                            .html('&times;')
                            .click(function() {
                                colDiv.remove();
                                filesToUpload.splice(index, 1); // Remove the file from the filesToUpload array
                                updateFileInput(); // Update the file input
                            });

                        imageWrapper.append(imgElement).append(removeButton);
                        colDiv.append(imageWrapper);
                        $('#image-preview').append(colDiv);
                    };
                    reader.readAsDataURL(file);
                });
            }
        });

        function updateFileInput() {
            const dataTransfer = new DataTransfer();
            filesToUpload.forEach(file => dataTransfer.items.add(file));
            $('#images')[0].files = dataTransfer.files;
        }

        $('#product-form').on('submit', function(e) {
            updateFileInput();
        });
    });
</script>
@endsection
