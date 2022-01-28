<div class="modal micromodal-slide" id="modal-1" aria-hidden="true">
    <div class="modal__overlay" tabindex="-1" data-micromodal-close>
        <div class="modal__container" role="dialog" aria-modal="true" aria-labelledby="modal-1-title">
            <header class="modal__header">
                <h2 class="modal__title" id="modal-1-title">
                    {{ trans('app.license_key_for_project', ['name' => $project->name]) }}
                </h2>
                <button class="modal__close" aria-label="Close modal" data-micromodal-close></button>
            </header>
            <main class="modal__content" id="modal-1-content">
                <div class="project_license_key__modal">
                    <code class="project_license_key__modal_inner">
                        {{ $project->license_key }}
                    </code>
                </div>
                <p>
                    {{ trans('app.license_key_instructions') }}
                </p>
                <p>
                    {{ trans('app.license_key_private') }}
                </p>
            </main>
            <div class="modal__footer">
                <button class="button button_secondary" data-micromodal-close
                        aria-label="Close this dialog window">{{ trans('app.close') }}</button>
            </div>
        </div>
    </div>
</div>
