import DropzonePreview from '@admin/common/components/dropzone/DropzonePreview';
import { DropzoneVariant } from '@admin/common/components/dropzone/Dropzone';
import React, { ReactNode } from 'react';
import clsx from 'clsx';
import { UploadFile } from '@admin/common/interfaces/UploadFile';

interface DropzoneThumbnailProps {
    file: UploadFile;
    removeFile: (file: UploadFile) => void;
    index?: number;
    variant: DropzoneVariant;
    isMainThumbnail?: boolean;
    children?: ReactNode;
}

const variantClasses: Record<DropzoneVariant, string> = {
    [DropzoneVariant.Avatar]: 'absolute flex top-0 h-40 w-40 rounded-full',
    [DropzoneVariant.Single]: 'absolute flex top-0 rounded-lg w-full h-full border border-gray-200',
    [DropzoneVariant.Multiple]:
        'relative flex sm:h-48 sm:w-48 max-w-lg w-full h-auto rounded-lg border border-gray-100',
};

const DropzoneThumbnail: React.FC<DropzoneThumbnailProps> = ({
    file,
    removeFile,
    index,
    variant,
    isMainThumbnail = false,
    children,
}) => {
    const baseRounded = variant === DropzoneVariant.Avatar ? 'rounded-full' : 'rounded-lg';

    return (
        <div key={index ?? 0} className={clsx(variantClasses[variant])}>
            {variant === DropzoneVariant.Multiple ? (
                <div className="relative">
                    <img
                        className={clsx(baseRounded, 'mx-auto object-cover w-full h-full')}
                        src={file.preview}
                        alt={file.name}
                    />
                    {isMainThumbnail && (
                        <div className="absolute bg-black/40 inset-x-0 bottom-0 p-4 text-white text-center font-medium tracking-wide uppercase">
                            Miniaturka
                        </div>
                    )}
                </div>
            ) : (
                <img className={clsx(baseRounded, 'mx-auto object-cover w-full')} src={file.preview} alt={file.name} />
            )}

            <DropzonePreview removeFile={() => removeFile(file)} file={file} additionalClasses={baseRounded}>
                {children}
            </DropzonePreview>
        </div>
    );
};

export default DropzoneThumbnail;
