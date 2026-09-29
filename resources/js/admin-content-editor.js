import tinymce from 'tinymce/tinymce';

import 'tinymce/icons/default';
import 'tinymce/models/dom';
import 'tinymce/themes/silver';

import 'tinymce/plugins/advlist';
import 'tinymce/plugins/autolink';
import 'tinymce/plugins/code';
import 'tinymce/plugins/fullscreen';
import 'tinymce/plugins/image';
import 'tinymce/plugins/link';
import 'tinymce/plugins/lists';
import 'tinymce/plugins/searchreplace';
import 'tinymce/plugins/table';
import 'tinymce/plugins/visualblocks';
import 'tinymce/plugins/wordcount';

import 'tinymce/skins/ui/oxide/skin.css';
import 'tinymce/skins/ui/oxide/content.css';
import 'tinymce/skins/content/default/content.css';

const editorSelector = 'textarea.content-editor';

const editorContentStyle = `
    body {
        color: #1f2937;
        font-family: Inter, "Instrument Sans", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        font-size: 17px;
        line-height: 1.75;
        margin: 0 auto;
        max-width: 920px;
        padding: 28px;
    }

    p { margin: 0 0 1.1rem; }
    h1, h2, h3, h4, h5, h6 {
        color: #111827;
        font-weight: 700;
        line-height: 1.2;
        margin: 1.6rem 0 .85rem;
    }
    h1 { font-size: 2.25rem; }
    h2 { font-size: 1.85rem; }
    h3 { font-size: 1.55rem; }
    h4 { font-size: 1.3rem; }
    h5 { font-size: 1.12rem; }
    h6 { font-size: 1rem; }
    ul, ol { margin: 0 0 1.2rem 1.4rem; padding: 0; }
    li { margin-bottom: .35rem; }
    blockquote {
        border-left: 4px solid #0d6efd;
        color: #4b5563;
        font-size: 1.05rem;
        margin: 1.4rem 0;
        padding: .4rem 0 .4rem 1rem;
    }
    pre {
        background: #111827;
        border-radius: 10px;
        color: #f9fafb;
        overflow-x: auto;
        padding: 1rem;
    }
    table {
        border-collapse: collapse;
        margin: 1.4rem 0;
        width: 100%;
    }
    table td, table th {
        border: 1px solid #d1d5db;
        padding: .65rem;
    }
    table th { background: #f3f4f6; font-weight: 700; }
    img {
        border-radius: 10px;
        height: auto;
        max-width: 100%;
    }
    a { color: #0d6efd; text-decoration: underline; }
    hr { border: 0; border-top: 1px solid #d1d5db; margin: 2rem 0; }
`;

function initializeContentEditors() {
    const editors = document.querySelectorAll(editorSelector);

    if (editors.length === 0) {
        return;
    }

    tinymce.init({
        selector: editorSelector,
        license_key: 'gpl',
        promotion: false,
        branding: false,
        skin: false,
        content_css: false,
        min_height: 500,
        resize: true,
        menubar: 'file edit view insert format table',
        menu: {
            file: { title: 'File', items: 'newdocument' },
            edit: { title: 'Edit', items: 'undo redo | cut copy paste pastetext | selectall | searchreplace' },
            view: { title: 'View', items: 'visualblocks | fullscreen' },
            insert: { title: 'Insert', items: 'link image inserttable | hr' },
            format: { title: 'Format', items: 'bold italic underline strikethrough superscript subscript | blocks align | removeformat' },
            table: { title: 'Table', items: 'inserttable | cell row column | tableprops deletetable' },
        },
        plugins: [
            'advlist',
            'autolink',
            'code',
            'fullscreen',
            'image',
            'link',
            'lists',
            'searchreplace',
            'table',
            'visualblocks',
            'wordcount',
        ],
        toolbar: [
            'undo redo | blocks | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify',
            'bullist numlist | blockquote | link image table hr | removeformat | code fullscreen',
        ].join(' | '),
        block_formats: 'Paragraph=p; Heading 1=h1; Heading 2=h2; Heading 3=h3; Heading 4=h4; Heading 5=h5; Heading 6=h6; Blockquote=blockquote; Preformatted=pre',
        image_advtab: true,
        image_caption: true,
        image_title: true,
        image_dimensions: true,
        automatic_uploads: false,
        file_picker_types: 'image',
        link_assume_external_targets: 'https',
        default_link_target: '_self',
        convert_urls: false,
        invalid_elements: 'script,style,iframe,object,embed,form,input,button',
        table_use_colgroups: true,
        table_default_attributes: {
            class: 'table table-bordered',
        },
        table_default_styles: {
            width: '100%',
        },
        contextmenu: 'link image table',
        content_style: editorContentStyle,
        setup(editor) {
            editor.on('init', () => {
                const textarea = editor.getElement();
                textarea?.closest('.content-editor-wrap')?.classList.add('is-ready');
            });
        },
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initializeContentEditors();

    document.querySelectorAll('form').forEach((form) => {
        form.addEventListener('submit', () => {
            tinymce.triggerSave();
        });
    });
});
