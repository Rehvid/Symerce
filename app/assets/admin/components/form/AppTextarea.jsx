import React, { useRef } from 'react';
import Editor from '@/admin/components/editor/Editor';
import DOMPurify from 'quill/formats/link';

const AppTextarea = ({ title, value, onChange, isRequired }) => {
    const quillRef = useRef();

    return (
        <div>
            <h1 className="mb-2 flex flex-col gap-2 text-gray-500">
                <span className="flex items-center">
                    {title} {isRequired && <span className="pl-1 text-red-500">*</span>}{' '}
                </span>
            </h1>
            <Editor
                defaultValue={value}
                ref={quillRef}
                onTextChange={() => {
                    onChange(DOMPurify.sanitize(quillRef?.current?.getSemanticHTML()));
                }}
            />
        </div>
    );
};

export default AppTextarea;
