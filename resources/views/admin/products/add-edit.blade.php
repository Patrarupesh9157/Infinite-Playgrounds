<div class="offcanvas offcanvas-end custom-offcanvas-width {{ session('offcanvas') }}" tabindex="-1" id="productform"
    aria-labelledby="productform" data-bs-backdrop="static">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddProductLabel" class="offcanvas-title">
            @if (session('productId'))
                Edit Product
            @else
                Add Product
            @endif
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form id="AddProductForm" method="POST" enctype="multipart/form-data"
            action="@if (isset($product)) {{ route('admin.products.update', [$product->id]) }} @else {{ route('admin.products.store') }} @endif">
            @csrf
            @if (isset($product))
                @method('PUT')
            @endif

            <!-- Name Input -->
            <div class="form-group mb-2">
                <label for="name">Name<span class="required_field_sign"> *</span></label>
                <input type="text" id="name" name="name" class="form-control"
                    value="{{ isset($product) ? $product->name : '' }}" required>
                @error('name')
                    <span class="text-danger mb-3">{{ $message }}</span>
                @enderror
            </div>

            <!-- Stitches Input -->
            <div class="form-group mb-2">
                <label for="stitches">Stitches<span class="required_field_sign"> *</span></label>
                <input type="number" id="stitches" name="stitches" class="form-control"
                    value="{{ isset($product) ? $product->stitches : '' }}" required>
                @error('stitches')
                    <span class="text-danger mb-3">{{ $message }}</span>
                @enderror
            </div>


            <!-- Design Name Input -->
            <div class="form-group mb-2">
                <label for="design_name">Design Name<span class="required_field_sign"> *</span></label>
                <input type="text" id="design_name" name="design_name" class="form-control"
                    value="{{ isset($product) ? $product->design_name : '' }}" required>
                @error('design_name')
                    <span class="text-danger mb-3">{{ $message }}</span>
                @enderror
            </div>

            <!-- Rate Input -->
            <div class="form-group mb-2">
                <label for="rate">Rate<span class="required_field_sign"> *</span></label>
                <input type="number" id="rate" name="rate" class="form-control"
                    value="{{ isset($product) ? $product->rate : '' }}" required>
                @error('rate')
                    <span class="text-danger mb-3">{{ $message }}</span>
                @enderror
            </div>

            <!-- Height Input -->
            <div class="form-group mb-2">
                <label for="height">Height<span class="required_field_sign"> *</span></label>
                <input type="number" id="height" name="height" class="form-control"
                    value="{{ isset($product) ? $product->height : '' }}" required>
                @error('height')
                    <span class="text-danger mb-3">{{ $message }}</span>
                @enderror
            </div>

            <!-- Areas Dropdown -->
            <div class="form-group mb-2">
                <label for="area_id">Area<span class="required_field_sign"> *</span></label>
                <select id="area_id" name="area_id" class="form-control select2">
                    @foreach ($areas as $area)
                        <option value="{{ $area->id }}"
                            {{ isset($product) && $product->area_id == $area->id ? 'selected' : '' }}>
                            {{ $area->name }}
                        </option>
                    @endforeach
                </select>
                @error('area_id')
                    <span class="text-danger mb-3">{{ $message }}</span>
                @enderror
            </div>

            <!-- Concepts Dropdown -->
            <div class="form-group mb-2">
                <label for="concept_id">Concept<span class="required_field_sign"> *</span></label>
                <select id="concept_id" name="concept_id" class="form-control select2">
                    @foreach ($concepts as $concept)
                        <option value="{{ $concept->id }}"
                            {{ isset($product) && $product->concept_id == $concept->id ? 'selected' : '' }}>
                            {{ $concept->name }}
                        </option>
                    @endforeach
                </select>
                @error('concept_id')
                    <span class="text-danger mb-3">{{ $message }}</span>
                @enderror
            </div>

            <!-- Fabrics Dropdown -->
            <div class="form-group mb-2">
                <label for="fabric_id">Fabric<span class="required_field_sign"> *</span></label>
                <select id="fabric_id" name="fabric_id" class="form-control select2">
                    @foreach ($fabrics as $fabric)
                        <option value="{{ $fabric->id }}"
                            {{ isset($product) && $product->fabric_id == $fabric->id ? 'selected' : '' }}>
                            {{ $fabric->name }}
                        </option>
                    @endforeach
                </select>
                @error('fabric_id')
                    <span class="text-danger mb-3">{{ $message }}</span>
                @enderror
            </div>

            <!-- Pannas Dropdown -->
            <div class="form-group mb-2">
                <label for="panna_id">Panna<span class="required_field_sign"> *</span></label>
                <select id="panna_id" name="panna_id" class="form-control select2">
                    @foreach ($pannas as $panna)
                        <option value="{{ $panna->id }}"
                            {{ isset($product) && $product->panna_id == $panna->id ? 'selected' : '' }}>
                            {{ $panna->name }}
                        </option>
                    @endforeach
                </select>
                @error('panna_id')
                    <span class="text-danger mb-3">{{ $message }}</span>
                @enderror
            </div>

            <!-- Technically Concepts Dropdown -->
            <div class="form-group mb-2">
                <label for="technical_concept_id">Technical Concept<span class="required_field_sign"> *</span></label>
                <select id="technical_concept_id" name="technical_concept_id" class="form-control select2">
                    @foreach ($technicalConcepts as $technicalConcept)
                        <option value="{{ $technicalConcept->id }}"
                            {{ isset($product) && $product->technical_concept_id == $technicalConcept->id ? 'selected' : '' }}>
                            {{ $technicalConcept->name }}
                        </option>
                    @endforeach
                </select>
                @error('technical_concept_id')
                    <span class="text-danger mb-3">{{ $message }}</span>
                @enderror
            </div>

            <!-- Use Ins Dropdown -->
            <div class="form-group mb-2">
                <label for="use_in_id">Use In<span class="required_field_sign"> *</span></label>
                <select id="use_in_id" name="use_in_id" class="form-control select2">
                    @foreach ($useIns as $useIn)
                        <option value="{{ $useIn->id }}"
                            {{ isset($product) && $product->use_in_id == $useIn->id ? 'selected' : '' }}>
                            {{ $useIn->name }}
                        </option>
                    @endforeach
                </select>
                @error('use_in_id')
                    <span class="text-danger mb-3">{{ $message }}</span>
                @enderror
            </div>

            <!-- Yarns Dropdown -->
            <div class="form-group mb-2">
                <label for="yarn_id">Yarn<span class="required_field_sign"> *</span></label>
                <select id="yarn_id" name="yarn_id" class="form-control select2">
                    @foreach ($yarns as $yarn)
                        <option value="{{ $yarn->id }}"
                            {{ isset($product) && $product->yarn_id == $yarn->id ? 'selected' : '' }}>
                            {{ $yarn->name }}
                        </option>
                    @endforeach
                </select>
                @error('yarn_id')
                    <span class="text-danger mb-3">{{ $message }}</span>
                @enderror
            </div>



            <!-- Price Input -->
            <div class="form-group mb-2">
                <label for="price">Price<span class="required_field_sign"> *</span></label>
                <input type="number" id="price" name="price" class="form-control"
                    value="{{ isset($product) ? $product->price : '' }}" required>
                @error('price')
                    <span class="text-danger mb-3">{{ $message }}</span>
                @enderror
            </div>

            <!-- Image Input -->
            <div class="form-group mb-2">
                <label for="images">Product Images<span class="required_field_sign"> *</span></label>
                <input type="file" id="images" name="images[]" class="form-control" accept="image/*"
                    multiple>
                @error('images')
                    <span class="text-danger mb-3">{{ $message }}</span>
                @enderror

                <!-- Display existing images for update -->
                @if (isset($product) && $product->images)
                    <div id="existing-images" class="row mt-3">
                        @foreach (json_decode($product->images) as $index => $image)
                            <div class="col-md-3 position-relative mb-3" id="existing-image-{{ $index }}">
                                <div class="image-wrapper">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Product Image" width="100%">
                                    <button type="button"
                                        class="btn btn-secondary btn-sm position-absolute top-0 end-0 remove-existing-image"
                                        data-index="{{ $index }}">×</button>
                                </div>
                                <input type="hidden" name="existing_images[]" value="{{ $image }}">
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Image preview section for new uploads -->
            <div id="image-preview" class="row mt-3"></div>

            <!-- Additional fields like Design Name, Rate, etc. can go here -->

            <button type="submit" class="btn btn-primary mt-3 submit">Save</button>
        </form>
    </div>
</div>
