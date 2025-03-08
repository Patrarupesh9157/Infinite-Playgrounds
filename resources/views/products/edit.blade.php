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

<div class="container mt-4">
    <h1>Edit Product</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="product-form" action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control" id="name" value="{{ $product->name }}" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" step="0.01" name="price" class="form-control" id="price" value="{{ $product->price }}" required>
        </div>
        <div class="mb-3">
            <label for="stitch" class="form-label">Stitch</label>
            <input type="text" name="stitch" class="form-control" id="stitch" value="{{ $product->stitch }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="description" rows="3" required>{{ $product->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="images" class="form-label">Images</label>
            <input type="file" name="images[]" class="form-control" id="images" multiple>
            <div class="container mt-4">
                <div class="row" id="image-preview">
                    @foreach (json_decode($product->images) as $image)
                        <div class="col-md-3 position-relative mb-3 existing-image" id="image-{{ $image }}">
                            <div class="image-wrapper">
                                <img src="{{ asset('images/product/' . $image) }}" class="img-fluid img-thumbnail">
                                <button type="button" class="btn btn-secondary" onclick="removeExistingImage('{{ $image }}')">&times;</button>
                            </div>
                            <input type="hidden" name="existing_images[]" value="{{ $image }}">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <input type="hidden" name="deleted_images" id="deleted_images" value="">
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        let filesToUpload = [];

        $('#images').on('change', function() {
            // Keep existing previews and append new ones
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
                                filesToUpload = filesToUpload.filter(f => f.name !== file.name); // Remove the file from the filesToUpload array
                                updateFileInput(); // Update the file input
                            });

                        imageWrapper.append(imgElement).append(removeButton);
                        colDiv.append(imageWrapper);
                        $('#image-preview').append(colDiv);
                    };
                    reader.readAsDataURL(file);
                    filesToUpload.push(file);
                });
                updateFileInput(); // Update the file input
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

    function removeExistingImage(image) {
        // Remove the image from the DOM
        document.getElementById('image-' + image).remove();

        // Add the image to the list of deleted images
        let deletedImages = document.getElementById('deleted_images').value;
        deletedImages = deletedImages ? JSON.parse(deletedImages) : [];
        deletedImages.push(image);
        document.getElementById('deleted_images').value = JSON.stringify(deletedImages);
    }
</script>
@endsection
