<div>
    <script src="https://www.google.com/recaptcha/api.js?hl=fa" async defer></script>
    <div class="g-recaptcha @error('g-recaptcha-response') is-invalid @enderror" data-sitekey="{{ $clientKey }}"></div>

    @error('g-recaptcha-response')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>