<!-- resources/views/admin/fabric/add-edit.blade.php -->
<div class="offcanvas offcanvas-end w-45 {{ session('offcanvas') }}" tabindex="-1" id="fabricform"
    aria-labelledby="fabricform" data-bs-backdrop="static">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddFabricLabel" class="offcanvas-title">
            @if (session('fabricId'))
                Edit Fabric
            @else
                Add Fabric
            @endif
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form id="AddFabricForm" method="POST" enctype="multipart/form-data"
            action="@if (session('fabricId')) {{ route('admin.category.fabric.update', [session('fabricId')]) }} @else {{ route('admin.category.fabric.store') }} @endif">
            @csrf
            @if (isset($fabric))
                @method('PUT')
            @endif
            <input type="hidden" id="fabric_id" name="fabric_id"
                value="{{ session('fabricId') ? session('fabricId') : '' }}">
            <div class="form-group mb-2">
                <label for="name">Name<span class="required-field-sign"> *</span></label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Fabric Name"
                    value="{{ old('name') }}">
                @error('name')
                    <span class="text-danger mb-3">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-3 submit">Save</button>
        </form>
    </div>
</div>
