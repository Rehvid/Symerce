import { useState } from 'react';
import { convertFileToBase64 } from '@/admin/utils/helper';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import { createApiConfig } from '@/shared/api/ApiConfig';
import { useApi } from '@/admin/hooks/useApi';

export const useDropzoneLogic = (
    setValue,
    onSuccessRemove = null,
    value = [],
    maxFiles = 1,
    maxSize = 5,
    accept = ['image/jpeg', 'image/png'],
) => {
    const [errors, setErrors] = useState({});
    const { handleApiRequest } = useApi();

    const onDrop = (acceptedFiles) => {
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
                const sizeMB = maxSize.toFixed(2);
                setErrors({
                    message: `Plik jest za duży. Maksymalny rozmiar to ${sizeMB} MB`,
                });
                return false;
            }

            return true;
        });

        if (filteredFiles.length === 0) {
            return;
        }

        const withPreview = filteredFiles.map((file) =>
            Object.assign(file, {
                preview: URL.createObjectURL(file),
            }),
        );

        setErrors({});
        handleFilesChange(withPreview);
    };

    const handleFilesChange = async (filesArray) => {
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
                };
            }),
        );

        const newValue = [...value, ...processedFiles].slice(0, maxFiles);
        setValue(newValue);
    };

    const removeFile = (file) => {
        const updatedFiles = value.filter((item) => item !== file);

        if (file.id) {
            handleApiRequest(createApiConfig(`admin/files/${file.id}`, HTTP_METHODS.DELETE), {
                onSuccess: ({ message }) => {
                    if (typeof onSuccessRemove === 'function') {
                        onSuccessRemove(message);
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
