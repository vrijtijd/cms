import Sortable from 'sortablejs'

document.addEventListener("DOMContentLoaded", () => {
    const titleTableHeading = document.getElementById('title-table-heading')
    const defaultTitle = titleTableHeading.innerText

    const contentFiles = new Sortable(document.querySelector('#content-table tbody'), {
        animation: 150,
        items: 'tr',
        handle: '[data-is-drag-handle]',
        direction: 'vertical',
        ghostClass: 'bg-vt-blue-100',
        dragClass: 'hidden',
        forceFallback: true,

        onChange: () => {
            titleTableHeading.innerText = titleTableHeading.dataset.saveOrderTitle
            Livewire.emit('changeMade')
        }
    })

    window.getOrderedContentFiles = () => {
        return [...document.querySelectorAll('[data-content-file-slug]')].map((el, i) => {
            return [el.dataset.contentFileSlug, i + 1]
        })
    }

    Livewire.on('saveOrder', () => contentFiles.option('disabled', true))
    Livewire.on('changesSaved', () => {
        titleTableHeading.innerText = defaultTitle
        contentFiles.option('disabled', false)
    })
})
