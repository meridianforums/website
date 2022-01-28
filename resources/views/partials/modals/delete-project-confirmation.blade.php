<div class="modal micromodal-slide" id="modal-2" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
        <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
            <header class="modal__header">
                <h2 class="modal__title" id="modal-2-title">
                    {{ trans('app.remove_project_confirmation_title', ['name' => $project->name]) }}
                </h2>
                <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content" id="modal-2-content">
                <p>
                    {{ trans('app.remove_project_confirm') }}
                </p>
            </main>
            <div class="modal__footer">
                <button class="button button_primary" data-micromodal-close type="submit" onclick="event.preventDefault();
                                                     document.getElementById('delete-form').submit();"
                        aria-label="Delete project">{{ trans('app.remove_project_confirm_button') }}</button>
                <button class="button button_secondary" data-micromodal-close type="button"
                        aria-label="Close this dialog window">{{ trans('app.close') }}</button>
            </div>
            <form id="delete-form" action="{{ route('projects.destroy', $project) }}" method="POST">
                @method('DELETE')
                @csrf
            </form>
        </div>
    </div>
</div>
