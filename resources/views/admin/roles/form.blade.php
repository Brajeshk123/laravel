<div class="row">

<div class="col-md-12 mb-3">

<label>Name</label>

<input
type="text"
name="name"
value="{{ old('name',$role->name ?? '') }}"
class="form-control @error('name') is-invalid @enderror"
@disabled(($role->name ?? '') === 'Super Admin')>

@if(($role->name ?? '') === 'Super Admin')
<input
type="hidden"
name="name"
value="Super Admin">
@endif

@error('name')

<div class="invalid-feedback">

{{ $message }}

</div>

@enderror

</div>

</div>
