import React, { ForwardedRef, useEffect, useLayoutEffect, useRef } from 'react';
import Quill from 'quill';
import DOMPurify from 'quill/formats/link';

interface QuillEditorProps {
    readOnly?: boolean;
    defaultValue?: string;
    onTextChange?: (delta: any, oldDelta: any, source: string) => void;
    onSelectionChange?: (range: any, oldRange: any, source: string) => void;
}

const QuillEditor = React.forwardRef<Quill | null, QuillEditorProps>(
    ({ readOnly = false, defaultValue = '', onTextChange, onSelectionChange }, ref: ForwardedRef<Quill | null>) => {
        const containerRef = useRef<HTMLElement | null>(null);
        const defaultValueRef = useRef(defaultValue);
        const onTextChangeRef = useRef(onTextChange);
        const onSelectionChangeRef = useRef(onSelectionChange);

        useLayoutEffect(() => {
            onTextChangeRef.current = onTextChange;
            onSelectionChangeRef.current = onSelectionChange;
        }, [onTextChange, onSelectionChange]);

        useEffect(() => {
            if (ref && typeof ref !== 'function' && ref.current) {
                ref.current.enable(!readOnly);
            }
        }, [readOnly, ref]);

        useEffect(() => {
            const container = containerRef.current;
            if (!container) return;

            const editorContainer = container.ownerDocument.createElement('article');
            container.appendChild(editorContainer);

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
                readOnly,
            });

            if (ref && typeof ref !== 'function') {
                ref.current = quill;
            }

            if (defaultValueRef.current) {
                quill.clipboard.dangerouslyPasteHTML(DOMPurify.sanitize(defaultValueRef.current));
            }

            quill.on(Quill.events.TEXT_CHANGE, (delta, oldDelta, source) => {
                onTextChangeRef.current?.(delta, oldDelta, source);
            });

            quill.on(Quill.events.SELECTION_CHANGE, (range, oldRange, source) => {
                onSelectionChangeRef.current?.(range, oldRange, source);
            });

            return () => {
                if (ref && typeof ref !== 'function') {
                    ref.current = null;
                }
                container.innerHTML = '';
            };
        }, [ref, readOnly]);

        return <section className="bg-white" ref={containerRef}></section>;
    },
);

export default QuillEditor;
