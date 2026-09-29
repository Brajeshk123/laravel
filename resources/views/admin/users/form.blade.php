<div class="row">

@can(isset($user) ? 'edit users' : 'create users')
<div class="col-md-6 mb-3">

<label>Name</label>

<input
type="text"
name="name"
class="form-control @error('name') is-invalid @enderror"
value="{{ old('name',$user->name ?? '') }}">

@error('name')

<div class="invalid-feedback">

{{ $message }}

</div>

@enderror

</div>

<div class="col-md-6 mb-3">

<label>Email</label>

<input
type="email"
name="email"
class="form-control @error('email') is-invalid @enderror"
value="{{ old('email',$user->email ?? '') }}">

@error('email')

<div class="invalid-feedback">

{{ $message }}

</div>

@enderror
</div>

<div class="col-md-6 mb-3">

<label>Phone</label>

<input
type="text"
name="phone"
class="form-control @error('phone') is-invalid @enderror"
value="{{ old('phone',$user->phone ?? '') }}">

@error('phone')

<div class="invalid-feedback">

{{ $message }}

</div>

@enderror
</div>

<div class="col-md-6 mb-3">

    <label for="role" class="form-label">
        Role <span class="text-danger">*</span>
    </label>

    <select
        name="role"
        id="role"
        class="form-select @error('role') is-invalid @enderror">

        <option value="">
            Select Role
        </option>

        @foreach($roles as $role)

            <option
                value="{{ $role->name }}"
                @selected(
                    old(
                        'role',
                        isset($user) ? $user->getRoleNames()->first() : ''
                    ) === $role->name
                )>

                {{ $role->name }}

            </option>

        @endforeach

    </select>

    @error('role')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror

</div>

<div class="col-md-6 mb-3">

<label>Password</label>

<div class="position-relative">

<input
type="password"
name="password"
class="form-control pe-5 js-toggle-password-input">

<button
type="button"
class="btn position-absolute top-50 end-0 translate-middle-y border-0 bg-transparent text-muted js-toggle-password"
aria-label="Show password">
<i class="bi bi-eye"></i>
</button>

</div>

</div>

<div class="col-md-6 mb-3">

<label>Confirm Password</label>

<div class="position-relative">

<input
type="password"
name="password_confirmation"
class="form-control pe-5 js-toggle-password-input">

<button
type="button"
class="btn position-absolute top-50 end-0 translate-middle-y border-0 bg-transparent text-muted js-toggle-password"
aria-label="Show confirm password">
<i class="bi bi-eye"></i>
</button>

</div>

</div>

<div class="col-md-6 mb-3">

<label>Status</label>

<select

name="status"

class="form-select">

<option
value="1"
@selected(old('status',$user->status ?? 1)==1)>

Active

</option>

<option
value="0"
@selected(old('status',$user->status ?? 1)==0)>

Inactive

</option>

</select>

</div>

<div class="col-md-6 mb-3">

<label>Profile Image</label>

<input
type="file"
name="profile_image"
class="form-control">

@if(isset($user) && !empty($user->profile_image))

<img

src="{{ asset('storage/'.$user->profile_image) }}"

width="80"

class="mt-3 rounded">

@endif
</div>

</div>
@endcan

@once
@push('js')
<script>
document.addEventListener('click', function (event) {
    const button = event.target.closest('.js-toggle-password');

    if (!button) {
        return;
    }

    const wrapper = button.closest('.position-relative');
    const input = wrapper.querySelector('.js-toggle-password-input');
    const icon = button.querySelector('i');
    const shouldShow = input.type === 'password';

    input.type = shouldShow ? 'text' : 'password';
    icon.classList.toggle('bi-eye', !shouldShow);
    icon.classList.toggle('bi-eye-slash', shouldShow);
    button.setAttribute('aria-label', shouldShow ? 'Hide password' : 'Show password');
});
</script>
@endpush
@endonce
