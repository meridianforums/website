<div class="modal micromodal-slide" id="modal-3" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
        <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
            <header class="modal__header">
                <h2 class="modal__title" id="modal-3-title">
                    {{ trans('app.toggle_license_key_status_title', ['name' => $project->name]) }}
                </h2>
                <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content" id="modal-3-content">
                <p>
                    @if($project->is_active)
                        {{ trans('app.toggle_license_key_msg_enabled') }}
                    @else
                        {{ trans('app.toggle_license_key_msg_disabled') }}
                    @endif
                </p>
            </main>
            <div class="modal__footer">
                <button class="button button_primary" data-micromodal-close type="submit" onclick="event.preventDefault();
                                                     document.getElementById('toggle-form').submit();"
                        aria-label="Delete project">{{ trans('app.toggle_license_key_status_button') }}</button>
                <button class="button button_secondary" data-micromodal-close type="button"
                        aria-label="Close this dialog window">{{ trans('app.close') }}</button>
            </div>
            <form id="toggle-form" action="{{ route('projects.toggle', $project) }}" method="POST">
                @method('POST')
                @csrf
            </form>
        </div>
    </div>
</div>
