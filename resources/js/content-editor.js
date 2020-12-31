import SimpleMDE from 'simplemde';

document.addEventListener("DOMContentLoaded", () => {
    window.editor = new SimpleMDE({
        element: document.getElementById('body'),
        promptURLs: true,
        hideIcons: ['preview', 'side-by-side'],
        spellChecker: false,
    })
})
