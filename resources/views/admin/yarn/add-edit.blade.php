<div class="offcanvas offcanvas-end w-45 {{ session('offcanvas') }}" tabindex="-1" id="yarnform"
    aria-labelledby="yarnform" data-bs-backdrop="static">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddYarnLabel" class="offcanvas-title">
            @if (session('yarnId'))
                Edit Yarn
            @else
                Add Yarn
            @endif
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form id="AddYarnForm" method="POST" enctype="multipart/form-data"
            action="@if (session('yarnId')) {{ route('admin.category.yarn.update', [session('yarnId')]) }} @else {{ route('admin.category.yarn.store') }} @endif">
            @csrf
            @if (isset($yarn))
                @method('PUT')
            @endif
            <input type="hidden" id="yarn_id" name="yarn_id"
                value="{{ session('yarnId') ? session('yarnId') : '' }}">
            <div class="form-group mb-2">
                <label for="name">Name<span class="required-field-sign"> *</span></label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Yarn Name"
                    value="{{ old('name') }}">
                @error('name')
                    <span class="text-danger mb-3">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-3 submit">Save</button>
        </form>
    </div>
</div>
