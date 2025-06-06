import { useState } from 'react';
import { convertFileToBase64 } from '@admin/common/utils/helper';
import { HttpMethod } from '@admin/common/enums/httpEnums';
import { useAdminApi } from '@admin/common/context/AdminApiContext';

interface FileWithPreview extends File {
    preview: string;
    content?: string;
    uuid?: string;
    id?: number;
}

interface Errors {
    message?: string;
}

type UseDropzoneLogicReturn = {
    onDrop: (acceptedFiles: File[]) => void;
    removeFile: (file: FileWithPreview) => void;
    errors: Errors;
};

export const useDropzoneLogic = (
    setValue: (files: FileWithPreview[]) => void,
    onSuccessRemove: ((message: string) => void) | null = null,
    value: FileWithPreview[] = [],
    maxFiles = 1,
    maxSize = 5,
    accept: string[] = ['image/jpeg', 'image/png'],
): UseDropzoneLogicReturn => {
    const [errors, setErrors] = useState<Errors>({});
    const { handleApiRequest } = useAdminApi();

    const onDrop = (acceptedFiles: File[]) => {
        const currentFiles = value.length === 0 ? [] : [...value];

        if (currentFiles.length + acceptedFiles.length > maxFiles) {
            setErrors({
                message: `Możesz przesłać maksymalnie ${maxFiles} plik${maxFiles > 1 ? 'ów' : ''}.`,
            });
            return;
        }

        const filteredFiles = acceptedFiles.filter((file) => {
            const isAcceptedType = accept.includes(file.type);
            const isAcceptedSize = file.size <= maxSize * 1024 * 1024;

            if (!isAcceptedType) {
                setErrors({
                    message: `Nieprawidłowy format pliku. Dozwolone: ${accept.join(', ')}`,
                });
                return false;
            }

            if (!isAcceptedSize) {
                setErrors({
                    message: `Plik jest za duży. Maksymalny rozmiar to ${maxSize.toFixed(2)} MB`,
                });
                return false;
            }

            return true;
        });

        if (filteredFiles.length === 0) return;

        const withPreview = filteredFiles.map((file) =>
            Object.assign(file, {
                preview: URL.createObjectURL(file),
            }),
        );

        setErrors({});
        handleFilesChange(withPreview);
    };

    const handleFilesChange = async (filesArray: FileWithPreview[]) => {
        const processedFiles = await Promise.all(
            filesArray.map(async (file) => {
                if (file.content) return file;

                const base64 = await convertFileToBase64(file);
                return {
                    size: file.size,
                    type: file.type,
                    name: file.name,
                    preview: file.preview,
                    content: base64,
                    uuid: crypto.randomUUID(),
                } as FileWithPreview;
            }),
        );

        const newValue = [...value, ...processedFiles].slice(0, maxFiles);
        setValue(newValue);
    };

    const removeFile =  async (file: FileWithPreview) => {
        const updatedFiles = value.filter((item) => item !== file);

        if (file.id) {
            await handleApiRequest(HttpMethod.DELETE, `admin/files/${file.id}`, {
                onSuccess: (_, __, message) => {
                    if (typeof onSuccessRemove === 'function') {
                        onSuccessRemove(message || '');
                    }
                    setValue(updatedFiles);
                },
            });
        } else {
            setValue(updatedFiles);
        }

        setErrors({});
    };

    return { onDrop, removeFile, errors };
};
