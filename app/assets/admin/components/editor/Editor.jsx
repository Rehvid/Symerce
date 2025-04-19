import { forwardRef, useEffect, useLayoutEffect, useRef } from 'react';
import Quill from 'quill';
import DOMPurify from 'quill/formats/link';

const QuillEditor = forwardRef(({ readOnly, defaultValue, onTextChange, onSelectionChange }, ref) => {
    const containerRef = useRef(null);
    const defaultValueRef = useRef(defaultValue);
    const onTextChangeRef = useRef(onTextChange);
    const onSelectionChangeRef = useRef(onSelectionChange);

    useLayoutEffect(() => {
        onTextChangeRef.current = onTextChange;
        onSelectionChangeRef.current = onSelectionChange;
    });

    useEffect(() => {
        ref.current?.enable(!readOnly);
    }, [ref, readOnly]);

    useEffect(() => {
        const container = containerRef.current;
        const editorContainer = container.appendChild(container.ownerDocument.createElement('article'));

        const toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'],
            ['blockquote', 'code-block'],
            ['link', 'image', 'video', 'formula'],
            [{ list: 'ordered' }, { list: 'bullet' }, { list: 'check' }],
            [{ script: 'sub' }, { script: 'super' }],
            [{ indent: '-1' }, { indent: '+1' }],
            [{ header: [1, 2, 3, 4, 5, 6, false] }],
            [{ color: [] }, { background: [] }],
            [{ align: [] }],
            ['clean'],
        ];

        const quill = new Quill(editorContainer, {
            theme: 'snow',
            modules: {
                toolbar: toolbarOptions,
            },
        });

        ref.current = quill;

        if (defaultValueRef.current) {
            quill.clipboard.dangerouslyPasteHTML(DOMPurify.sanitize(defaultValueRef.current));
        }

        quill.on(Quill.events.TEXT_CHANGE, (...args) => {
            onTextChangeRef.current?.(...args);
        });

        quill.on(Quill.events.SELECTION_CHANGE, (...args) => {
            onSelectionChangeRef.current?.(...args);
        });

        return () => {
            ref.current = null;
            container.innerHTML = '';
        };
    }, [ref]);

    return <section className="bg-white" ref={containerRef}></section>;
});

export default QuillEditor;
