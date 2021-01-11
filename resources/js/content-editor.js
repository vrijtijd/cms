import SimpleMDE from 'simplemde';

document.addEventListener("DOMContentLoaded", () => {
    window.editor = new SimpleMDE({
        element: document.getElementById('body'),
        promptURLs: true,
        hideIcons: ['preview', 'side-by-side'],
        spellChecker: false,
        toolbar: [
            {
                name: "bold",
                action: SimpleMDE.toggleBold,
                className: "fa fa-bold",
                title: "Bold",
            },
            {
                name: "italic",
                action: SimpleMDE.toggleItalic,
                className: "fa fa-italic",
                title: "Italic",
            },
            {
                name: "heading",
                action: SimpleMDE.toggleHeadingSmaller,
                className: "fa fa-header",
                title: "Heading",
            },
            "|",
            {
                name: "quote",
                action: SimpleMDE.toggleBlockquote,
                className: "fa fa-quote-left",
                title: "Quote",
            },
            {
                name: "unordered-list",
                action: SimpleMDE.toggleUnorderedList,
                className: "fa fa-list-ul",
                title: "Generic List",
            },
            {
                name: "ordered-list",
                action: SimpleMDE.toggleOrderedList,
                className: "fa fa-list-ol",
                title: "Numbered List",
            },
            "|",
            {
                name: "link",
                action: SimpleMDE.drawLink,
                className: "fa fa-link",
                title: "Create Link",
            },
            {
                name: "image",
                action: () => {
                    Livewire.emit('openFilePicker')
                },
                className: "fa fa-picture-o",
                title: "Insert Image",
            },
            "|",
            {
                name: "fullscreen",
                action: SimpleMDE.toggleFullScreen,
                className: "fa fa-arrows-alt no-disable no-mobile",
                title: "Toggle Fullscreen",
            },
            "|",
            {
                name: "guide",
                action: "https://simplemde.com/markdown-guide",
                className: "fa fa-question-circle",
                title: "Markdown Guide",
            },
        ],
    })

    const insertImage = (filename) => {
        const codeMirror = window.editor.codemirror
        const cursorPosition = codeMirror.getCursor()
        codeMirror.replaceRange(`![](/uploads/${filename})`, cursorPosition)
    }

    Livewire.on('filePicked', insertImage);
    Livewire.on('fileUploaded', insertImage);
})
