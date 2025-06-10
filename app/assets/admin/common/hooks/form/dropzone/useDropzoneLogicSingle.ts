import { useState } from 'react';
import { useAdminApi } from '@admin/common/context/AdminApiContext';
import { FileMimeType } from '@admin/common/enums/fileMimeType';
import { UploadFile } from '@admin/common/interfaces/UploadFile';
import { convertToUploadFile, formatSizeMB, isAcceptedSize, isAcceptedType } from '@admin/common/utils/fileUtils';
import { HttpMethod } from '@admin/common/enums/httpEnums';

interface DropzoneLogicSingleProps {
    setValue: (file: UploadFile | null) => void;
    value?: UploadFile | null;
    onSuccessRemove?: ((message: string) => void) | null;
    maxSize?: number;
    accept?: FileMimeType[];
}

export const useDropzoneLogicSingle = ({
   setValue,
   value = null,
   accept = [FileMimeType.JPEG, FileMimeType.PNG],
   maxSize = 5,
   onSuccessRemove = null,
}: DropzoneLogicSingleProps) => {
    const [errors, setErrors] = useState<{ message?: string }>({});
    const { handleApiRequest } = useAdminApi();

    const onDrop = (acceptedFiles: File[]) => {
        const file = acceptedFiles[0];
        if (!file) return;

        if (!isAcceptedType(file, accept)) {
            setErrors({
                message: `Nieprawidłowy format pliku. Dozwolone: ${accept.join(', ')}`,
            });
            return;
        }

        if (!isAcceptedSize(file, maxSize)) {
            setErrors({
                message: `Plik jest za duży. Maksymalny rozmiar to ${formatSizeMB(maxSize)}`,
            });
            return;
        }

        const withPreview = Object.assign(file, {
            preview: URL.createObjectURL(file),
        });

        setErrors({});
        handleFilesChange(withPreview).catch((error) => {console.error(error)});
    };

    const handleFilesChange = async (file: File & { preview: string }) => {
        const newValue = await convertToUploadFile(file);

        setValue(newValue);
    };

    const removeFile = async () => {
        if (value?.id) {
            await handleApiRequest(HttpMethod.DELETE, `admin/files/${value.id}`, {
                onSuccess: (_, __, message) => {
                    if (typeof onSuccessRemove === 'function') {
                        onSuccessRemove(message || '');
                    }
                    setValue(null);
                },
            });
        } else {
            setValue(null);
        }

        setErrors({});
    };

    return { onDrop, removeFile, errors };
};
