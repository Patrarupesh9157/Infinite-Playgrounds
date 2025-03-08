<div class="offcanvas offcanvas-end w-45 {{ session('offcanvas') }}" tabindex="-1" id="areaform"
    aria-labelledby="areaform" data-bs-backdrop="static">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddAreaLabel" class="offcanvas-title">
            @if (session('areaId'))
                Edit Area
            @else
                Add Area
            @endif
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form id="AddAreaForm" method="POST" enctype="multipart/form-data"
            action="@if (session('areaId')) {{ route('admin.category.area.update', [session('areaId')]) }} @else {{ route('admin.category.area.store') }} @endif">
            @csrf
            @if (isset($area))
                @method('PUT')
            @endif
            <input type="hidden" id="area_id" name="area_id"
                value="{{ session('areaId') ? session('areaId') : '' }}">
            <div class="form-group mb-2">
                <label for="name">Name<span class="required-field-sign"> *</span></label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Area Name"
                    value="{{ old('name') }}">
                @error('name')
                    <span class="text-danger mb-3">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-3 submit">Save</button>
        </form>
    </div>
</div>
