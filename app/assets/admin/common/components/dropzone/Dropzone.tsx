import { FileRejection, useDropzone } from 'react-dropzone';
import PhotosIcon from '@/images/icons/photos.svg';
import React, { ReactNode } from 'react';
import clsx from 'clsx';

export enum DropzoneVariant {
    Single = 'single',
    Avatar = 'avatar',
    Multiple = 'multiple'
}

const variantClasses: Record<DropzoneVariant, string> = {
    [DropzoneVariant.Single]: 'max-w-lg min-h-[200px]',
    [DropzoneVariant.Avatar]: 'rounded-full h-40 w-40',
    [DropzoneVariant.Multiple]: 'max-w-[200px] rounded-lg',
};

interface Errors {
    message?: string;
}

interface DropzoneProps {
    onDrop: (acceptedFiles: File[], fileRejections: FileRejection[]) => void;
    errors?: Errors;
    variant?: DropzoneVariant;
    containerClasses?: string;
    children?: ReactNode;
}

const Dropzone: React.FC<DropzoneProps> = ({
   onDrop,
   errors,
   variant = DropzoneVariant.Single,
   containerClasses = '',
   children,
})  => {
    const { getRootProps, getInputProps } = useDropzone({ onDrop });

    return (
        <section className={clsx('container', containerClasses)}>
            <div
                {...getRootProps()}
                className={clsx(
                    'flex flex-col gap-2 px-4 py-2 justify-center items-center border border-dashed transition-all cursor-pointer rounded-lg',
                    variantClasses[variant],
                    errors?.message
                        ? 'border-red-500 hover:border-red-700 hover:border-2'
                        : 'border-gray-300 hover:border-primary-stronger'
                )}
            >
                <PhotosIcon className="w-5 h-5 text-gray-500" />
                <input {...getInputProps()} />
                <p className="text-center mt-1 text-xs">
                    <span className="text-gray-800">Upuść tutaj obraz, lub </span>
                    <span className="text-primary">Kliknij, aby przeglądać</span>
                </p>
            </div>

            {errors?.message && (
                <p className="mt-2 mb-2 pl-2 text-sm text-red-600">
                    {errors.message}
                </p>
            )}

            {children}
        </section>
    );
};
export default Dropzone;
