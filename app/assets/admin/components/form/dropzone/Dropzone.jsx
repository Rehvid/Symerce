import { useDropzone } from 'react-dropzone';
import React, { useEffect, useState } from 'react';
import { convertFileToBase64 } from '@/admin/utils/helper';
import { useApi } from '@/admin/hooks/useApi';
import { createApiConfig } from '@/shared/api/ApiConfig';
import { HTTP_METHODS } from '@/admin/constants/httpConstants';
import DropzoneContent from '@/admin/components/form/dropzone/DropzoneContent';

const Dropzone = ({
    setValue,
    onChange,
    renderModal,
    dropzoneThumbnailAdditionalActions = null,
    value = [],
    maxFiles = 1,
    maxSize = 5,
    accept = ['image/jpeg', 'image/png'],
}) => {
    const [errors, setErrors] = useState({});
    const { handleApiRequest } = useApi();

    const onDrop = (acceptedFiles) => {
        setValue((prevFiles) => {
            const currentFiles = [...prevFiles];

            if (currentFiles.length + acceptedFiles.length > maxFiles) {
                setErrors({
                    message: `Możesz przesłać maksymalnie ${maxFiles} plik${maxFiles > 1 ? 'ów' : ''}.`,
                });
                return prevFiles;
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

            if (filteredFiles.length === 0) return prevFiles;

            const withPreview = filteredFiles.map((file) =>
                Object.assign(file, {
                    preview: URL.createObjectURL(file),
                }),
            );

            const updated = [...currentFiles, ...withPreview];
            setErrors({});
            return updated;
        });
    };

    const { getRootProps, getInputProps } = useDropzone({
        onDrop,
    });

    useEffect(() => {
        const copyFiles = [...value];
        const newFiles = copyFiles.map((file) => {
            if (file.preview) {
                URL.revokeObjectURL(file.preview);
            }

            return {
                id: file.id,
                name: file.originalName,
                preview: file.path,
            };
        });

        setValue(newFiles);
    }, []);

    useEffect(() => {
        const handleFilesChange = async () => {
            const copyFiles = [...value];
            const base64Files = await Promise.all(
                copyFiles.map(async (file) => {
                    const base64 = await convertFileToBase64(file);
                    return {
                        size: file.size,
                        type: file.type,
                        name: file.name,
                        content: base64,
                    };
                }),
            );
            onChange?.(base64Files);
        };

        handleFilesChange();
    }, [value]);

    const removeFile = (file) => {
        const updatedFiles = value.filter((item) => item !== file);

        if (file.id) {
            handleApiRequest(createApiConfig(`admin/files/${file.id}`, HTTP_METHODS.DELETE), {
                onSuccess: () => {
                    setValue(updatedFiles);
                },
            });
        } else {
            setValue(updatedFiles);
        }

        setErrors({});
    };

    return (
        <DropzoneContent
            getRootProps={getRootProps}
            getInputProps={getInputProps}
            errors={errors}
            files={value}
            renderModal={renderModal}
            removeFile={removeFile}
            dropzoneThumbnailAdditionalActions={dropzoneThumbnailAdditionalActions}
        />
    );
};
export default Dropzone;
