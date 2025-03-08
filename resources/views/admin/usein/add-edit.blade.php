<div class="offcanvas offcanvas-end w-45 {{ session('offcanvas') }}" tabindex="-1" id="useinform"
    aria-labelledby="useinform" data-bs-backdrop="static">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddUseInLabel" class="offcanvas-title">
            @if (session('useInId'))
                Edit UseIn
            @else
                Add UseIn
            @endif
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form id="AddUseInForm" method="POST" enctype="multipart/form-data"
            action="@if (session('useInId')) {{ route('admin.category.usein.update', [session('useInId')]) }} @else {{ route('admin.category.usein.store') }} @endif">
            @csrf
            @if (isset($useIn))
                @method('PUT')
            @endif
            <input type="hidden" id="use_in_id" name="use_in_id"
                value="{{ session('useInId') ? session('useInId') : '' }}">
            <div class="form-group mb-2">
                <label for="name">Name<span class="required-field-sign"> *</span></label>
                <input type="text" id="name" name="name" class="form-control" placeholder="UseIn Name"
                    value="{{ old('name') }}">
                @error('name')
                    <span class="text-danger mb-3">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-3 submit">Save</button>
        </form>
    </div>
</div>
