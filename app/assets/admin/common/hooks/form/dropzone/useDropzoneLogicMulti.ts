import { useState } from 'react';
import { HttpMethod } from '@admin/common/enums/httpEnums';
import { useAdminApi } from '@admin/common/context/AdminApiContext';
import { UploadFile } from '@admin/common/interfaces/UploadFile';
import { convertToUploadFile, formatSizeMB, isAcceptedSize, isAcceptedType } from '@admin/common/utils/fileUtils';
import { FileMimeType } from '@admin/common/enums/fileMimeType';

interface DropzoneLogicMultiProps {
    setValue: (files: UploadFile[]) => void;
    value?: UploadFile[];
    onSuccessRemove?: ((message: string) => void) | null;
    maxFiles?: number;
    maxSize?: number;
    accept?: FileMimeType[];
}

export const useDropzoneLogicMulti = ({
    setValue,
    value = [],
    maxFiles = 1,
    maxSize = 5,
    accept = [FileMimeType.JPEG, FileMimeType.PNG],
    onSuccessRemove = null,
}: DropzoneLogicMultiProps) => {
    const [errors, setErrors] = useState<{ message?: string }>({});
    const { handleApiRequest } = useAdminApi();

    const onDrop = (acceptedFiles: File[]) => {
        const currentFiles = [...value];

        if (currentFiles.length + acceptedFiles.length > maxFiles) {
            setErrors({
                message: `Możesz przesłać maksymalnie ${maxFiles} plik${maxFiles > 1 ? 'ów' : ''}.`,
            });
            return;
        }

        const filteredFiles = acceptedFiles.filter((file) => {
            if (!isAcceptedType(file, accept)) {
                setErrors({
                    message: `Nieprawidłowy format pliku. Dozwolone: ${accept.join(', ')}`,
                });
                return false;
            }

            if (!isAcceptedSize(file, maxSize)) {
                setErrors({
                    message: `Plik jest za duży. Maksymalny rozmiar to ${formatSizeMB(maxSize)}`,
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
        handleFilesChange(withPreview).catch((error) => {
            console.error(error);
        });
    };

    const handleFilesChange = async (filesArray: (File & { preview: string })[]) => {
        const processedFiles = await Promise.all(
            filesArray.map(async (file) => {
                return await convertToUploadFile(file);
            }),
        );

        const newValue = [...value, ...processedFiles].slice(0, maxFiles);
        setValue(newValue);
    };

    const removeFile = async (file: UploadFile) => {
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
