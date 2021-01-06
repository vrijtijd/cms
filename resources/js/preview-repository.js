(function () {
    document.addEventListener("DOMContentLoaded", () => {
        const refreshPreviewButton = document.getElementById('refresh-preview-button')
        const previewFrame = document.getElementById('preview')
        const loadingIndicator = document.getElementById('loading-indicator')

        // Most of this code is to work around Livewire limitations. There is no way
        // to emit an event at the same time as firing an action, and loading states
        // don't work as expected when emiting an action, so I have to write a bit more
        // JS than normally
        //
        // @see https://github.com/livewire/livewire/issues/1741
        Livewire.on('buildStarted', () => {
            refreshPreviewButton.classList.add('invisible')
            previewFrame.classList.add('hidden')
            loadingIndicator.classList.remove('hidden')
        })

        Livewire.on('buildComplete', () => {
            previewFrame.contentWindow.location.reload()

            refreshPreviewButton.classList.remove('invisible')
            previewFrame.classList.remove('hidden')
            loadingIndicator.classList.add('hidden')
        })

        Livewire.emit('buildStarted')
    })
})()
