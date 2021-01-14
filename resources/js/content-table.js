import Sortable from 'sortablejs'

document.addEventListener("DOMContentLoaded", () => {
    const contentFiles = new Sortable(document.querySelector('#content-table tbody'), {
        animation: 150,
        items: 'tr',
        handle: '[data-is-drag-handle]',
        direction: 'vertical',
        ghostClass: 'bg-vt-blue-100',
        dragClass: 'hidden',
        forceFallback: true,

        onChange: () => {
            Livewire.emit('changeMade')
        }
    })

    window.getOrderedContentFiles = () => {
        return [...document.querySelectorAll('[data-content-file-slug]')].map((el, i) => {
            return [el.dataset.contentFileSlug, i + 1]
        })
    }

    Livewire.on('saveOrder', () => contentFiles.option('disabled', true))
    Livewire.on('changesSaved', () => contentFiles.option('disabled', false))
})
