<div class="offcanvas offcanvas-end custom-offcanvas-width {{ session('offcanvas') }}" tabindex="-1" id="gameform"
    aria-labelledby="gameform" data-bs-backdrop="static">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddGameLabel" class="offcanvas-title">
            @if (session('gameId'))
                Edit Game
            @else
                Add Game
            @endif
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form id="AddGameForm" method="POST" enctype="multipart/form-data"
            action="@if (isset($game)) {{ route('admin.games.update', [$game->id]) }} @else {{ route('admin.games.store') }} @endif">
            @csrf
            @if (isset($game))
                @method('PUT')
            @endif

            <!-- Game Name Input -->
            <div class="form-group mb-2">
                <label for="name">Game Name<span class="required_field_sign"> *</span></label>
                <input type="text" id="name" name="name" class="form-control"
                    value="{{ isset($game) ? $game->name : '' }}" required>
                @error('name')
                    <span class="text-danger mb-3">{{ $message }}</span>
                @enderror
            </div>

            <!-- Description Input -->
            <div class="form-group mb-2">
                <label for="description">Description<span class="required_field_sign"> *</span></label>
                <textarea id="description" name="description" class="form-control" rows="3" required>{{ isset($game) ? $game->description : '' }}</textarea>
                @error('description')
                    <span class="text-danger mb-3">{{ $message }}</span>
                @enderror
            </div>

            <!-- HTML Input -->
            <div class="form-group mb-2">
                <label for="html">HTML<span class="required_field_sign"> *</span></label>
                <textarea id="html" name="html" class="form-control" rows="3" required>{{ isset($game) ? $game->html : '' }}</textarea>
                @error('html')
                    <span class="text-danger mb-3">{{ $message }}</span>
                @enderror
            </div>

            <!-- CSS Input -->
            <div class="form-group mb-2">
                <label for="css">CSS<span class="required_field_sign"> *</span></label>
                <textarea id="css" name="css" class="form-control" rows="3" required>{{ isset($game) ? $game->css : '' }}</textarea>
                @error('css')
                    <span class="text-danger mb-3">{{ $message }}</span>
                @enderror
            </div>

            <!-- JavaScript Input -->
            <div class="form-group mb-2">
                <label for="js">JavaScript<span class="required_field_sign"> *</span></label>
                <textarea id="js" name="js" class="form-control" rows="3" required>{{ isset($game) ? $game->js : '' }}</textarea>
                @error('js')
                    <span class="text-danger mb-3">{{ $message }}</span>
                @enderror
            </div>

            <!-- Images Input -->
            <div class="form-group mb-2">
                <label for="images">Game Images<span class="required_field_sign"> *</span></label>
                <input type="file" id="images" name="images[]" class="form-control" accept="image/*" multiple>
                @error('images')
                    <span class="text-danger mb-3">{{ $message }}</span>
                @enderror

                <!-- Display existing images for update -->
                @if (isset($game) && $game->images)
                    <div id="existing-images" class="row mt-3">
                        @foreach (json_decode($game->images) as $index => $image)
                            <div class="col-md-3 position-relative mb-3" id="existing-image-{{ $index }}">
                                <div class="image-wrapper">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Game Image" width="100%">
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

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary mt-3 submit">Save</button>
        </form>
    </div>
</div>
