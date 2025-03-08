<div class="offcanvas offcanvas-end w-45 {{ session('offcanvas') }}" tabindex="-1" id="conceptform"
    aria-labelledby="conceptform" data-bs-backdrop="static">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddConceptLabel" class="offcanvas-title">
            @if (session('conceptId'))
                Edit Concept
            @else
                Add Concept
            @endif
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form id="AddConceptForm" method="POST" enctype="multipart/form-data"
            action="@if (session('conceptId')) {{ route('admin.category.concept.update', [session('conceptId')]) }} @else {{ route('admin.category.concept.store') }} @endif">
            @csrf
            @if (isset($concepts))
                @method('PUT')
            @endif
            <input type="hidden" id="concept_id" name="concept_id"
                value="{{ session('conceptId') ? session('conceptId') : '' }}">
            <div class="form-group mb-2">
                <label for="name">Name<span class="requredfeild_sign"> *</span></label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Concept Name"
                    value="{{ old('name') }}">
                @error('name')
                    <span class="text-danger mb-3">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-3 submit">Save</button>
        </form>
    </div>
</div>
