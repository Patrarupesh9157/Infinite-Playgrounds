<div class="offcanvas offcanvas-end w-45 {{ session('offcanvas') }}" tabindex="-1" id="technicallyConceptForm"
    aria-labelledby="technicallyConceptForm" data-bs-backdrop="static">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddTechnicallyConceptLabel" class="offcanvas-title">
            @if (session('technicallyConceptId'))
                Edit Technically Concept
            @else
                Add Technically Concept
            @endif
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form id="AddTechnicallyConceptForm" method="POST" enctype="multipart/form-data"
            action="@if (session('technicallyConceptId')) {{ route('admin.category.technically-concept.update', [session('technicallyConceptId')]) }} @else {{ route('admin.category.technically-concept.store') }} @endif">
            @csrf
            @if (session('technicallyConceptId'))
                @method('PUT')
            @endif
            <input type="hidden" id="technically_concept_id" name="technically_concept_id"
                value="{{ session('technicallyConceptId') ? session('technicallyConceptId') : '' }}">
            <div class="form-group mb-2">
                <label for="name">Name<span class="required-field-sign"> *</span></label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Technically Concept Name"
                    value="{{ old('name') }}">
                @error('name')
                    <span class="text-danger mb-3">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-3 submit">Save</button>
        </form>
    </div>
</div>
