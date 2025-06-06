import { useRef } from 'react';
import Editor from '@admin/common/components/form/Editor';
import DOMPurify from 'quill/formats/link';
import Heading from '@admin/common/components/Heading';

const Textarea = ({ title, value, onChange, isRequired }) => {
    const quillRef = useRef();

    return (
        <div>
            <Heading level="h4" additionalClassNames="mb-4 flex flex-col gap-2">
                <span className="flex items-center">
                    {title} {isRequired && <span className="pl-1 text-red-500">*</span>}{' '}
                </span>
            </Heading>
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

export default Textarea;
