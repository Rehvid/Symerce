import React, { useRef } from 'react';
import Editor from '@/admin/components/editor/Editor';
import DOMPurify from 'quill/formats/link';


interface RichTextEditorProps {
  value: string;
  onChange: (value: string) => void;
}

const RichTextEditor: React.FC<RichTextEditorProps> = ({ value, onChange }) => {
  const quillRef = useRef<any>(null);

  return (
      <Editor
        defaultValue={value}
        ref={quillRef}
        onTextChange={() => {
          const html = quillRef?.current?.getSemanticHTML?.();
          onChange(DOMPurify.sanitize(html));
        }}
      />
  );
};

export default RichTextEditor;
