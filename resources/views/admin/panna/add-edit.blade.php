<div class="offcanvas offcanvas-end w-45 {{ session('offcanvas') }}" tabindex="-1" id="pannaform"
    aria-labelledby="pannaform" data-bs-backdrop="static">
    <div class="offcanvas-header">
        <h5 id="offcanvasAddPannaLabel" class="offcanvas-title">
            @if (session('pannaId'))
                Edit Panna
            @else
                Add Panna
            @endif
        </h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body mx-0 flex-grow-0 pt-0 h-100">
        <form id="AddPannaForm" method="POST" enctype="multipart/form-data"
            action="@if (session('pannaId')) {{ route('admin.category.panna.update', [session('pannaId')]) }} @else {{ route('admin.category.panna.store') }} @endif">
            @csrf
            @if (isset($panna))
                @method('PUT')
            @endif
            <input type="hidden" id="panna_id" name="panna_id"
                value="{{ session('pannaId') ? session('pannaId') : '' }}">
            <div class="form-group mb-2">
                <label for="name">Name<span class="required-field-sign"> *</span></label>
                <input type="text" id="name" name="name" class="form-control" placeholder="Panna Name"
                    value="{{ old('name') }}">
                @error('name')
                    <span class="text-danger mb-3">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary mt-3 submit">Save</button>
        </form>
    </div>
</div>
