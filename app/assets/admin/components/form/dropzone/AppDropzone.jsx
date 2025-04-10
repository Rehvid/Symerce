import { useDropzone } from 'react-dropzone';
import PhotosIcon from '@/images/icons/photos.svg';
import React, { useEffect, useState } from 'react';
import AppDropzoneThumbnail from '@/admin/components/form/dropzone/AppDropzoneThumbnail';

const AppDropzone = ({
    value,
    onChange,
    renderModal,
    maxFiles = 1,
    maxSize = 5,
    accept = ['image/jpeg', 'image/png'],
}) => {
    const [files, setFiles] = useState(value || []);
    const [errors, setErrors] = useState({});

    const onDrop = (acceptedFiles) => {
        setFiles((prevFiles) => {
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
        return () => {
            files.forEach((file) => {
                if (file.preview) {
                    URL.revokeObjectURL(file.preview);
                }
            });
        };
    }, []);

    useEffect(() => {
        onChange?.(files);
    }, [files]);

    const removeFile = (file) => {
        setFiles(files.filter((item) => item !== file));
    };

    const hasError = errors && errors.message;

    return (
        <section className="container">
            <div
                {...getRootProps({
                    className: `dropzone max-w-full flex flex-col px-4 py-2 justify-center items-center min-h-[130px] border ${hasError ? 'border-red-500 hover:border-red-700 hover:border-2' : 'border-gray-300 hover:border-primary-stronger'} border-dashed rounded-md cursor-pointer hover:border-primary-stronger hover:scale-[105%] transition-all`,
                })}
            >
                <div>
                    <PhotosIcon />
                </div>
                <input {...getInputProps()} />
                <p className="text-center mt-1 text-xs">
                    <span className="text-gray-800">Drop your image here, or </span>
                    <span className="text-primary">Click to browse</span>
                </p>
            </div>

            {errors.message && <p className="mt-2 pl-2 text-sm text-red-600">{errors.message}</p>}

            {files && files.length > 0 && (
                <div className="grid grid-cols-3 gap-3 mt-[40px]">
                    {files.map((file, key) => (
                        <div key={key} className="group relative rounded-md border border-gray-200 flex p-2">
                            <AppDropzoneThumbnail file={file} renderModal={renderModal} removeFile={removeFile} />
                        </div>
                    ))}
                </div>
            )}
        </section>
    );
};
export default AppDropzone;
