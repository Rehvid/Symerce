import { normalizeFile } from '@admin/common/utils/helper';
import { useState } from 'react';
import { UploadFile } from '@admin/common/interfaces/UploadFile';
import DropzoneThumbnail from '@admin/common/components/dropzone/DropzoneThumbnail';
import Dropzone, { DropzoneVariant } from '@admin/common/components/dropzone/Dropzone';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import FormGroup from '@admin/common/components/form/FormGroup';
import { useDropzoneLogicSingle } from '@admin/common/hooks/form/dropzone/useDropzoneLogicSingle';
import { UseFormSetValue } from 'react-hook-form';

interface SingleImageUploaderProps {
    label: string;
    fieldName: string;
    setValue: UseFormSetValue<any>;
    initialValue?: UploadFile | null;
    variant?: DropzoneVariant;
    containerClasses?: string;
    onSuccessRemove?: ((message: string) => void) | null;
}

const SingleImageUploader = ({
 label,
 fieldName,
 setValue,
 initialValue,
 onSuccessRemove = null,
 variant = DropzoneVariant.Single,
 containerClasses = 'max-w-lg relative',
}: SingleImageUploaderProps ) => {
    const [file, setFile] = useState<UploadFile | null>(normalizeFile(initialValue));
    const internalSetValue = (value: UploadFile | null) => {
        setFile(value);
        setValue(fieldName, value);
    };

    const { onDrop, removeFile, errors } = useDropzoneLogicSingle({
        setValue: internalSetValue,
        value: file,
        onSuccessRemove: onSuccessRemove
    });

    return (
        <FormGroup label={<InputLabel label={label} />}>
            <Dropzone
                onDrop={onDrop}
                errors={errors}
                containerClasses={containerClasses}
                variant={variant}
            >
                {file && (
                    <DropzoneThumbnail
                        file={file}
                        removeFile={removeFile}
                        variant={variant}
                    />
                )}
            </Dropzone>
        </FormGroup>
    );
}

export default SingleImageUploader;
