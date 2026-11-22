{{-- File picker whose button text follows the site language (the native one follows the browser). --}}
<label class="file-field">
    <input type="file" name="{{ $name }}" @isset($accept) accept="{{ $accept }}" @endisset
           onchange="this.parentNode.querySelector('.file-name').textContent = this.files.length ? this.files[0].name : this.parentNode.querySelector('.file-name').dataset.empty">
    <span class="file-button">{{ __('Choose file') }}</span>
    <span class="file-name" data-empty="{{ __('No file chosen') }}">{{ __('No file chosen') }}</span>
</label>
