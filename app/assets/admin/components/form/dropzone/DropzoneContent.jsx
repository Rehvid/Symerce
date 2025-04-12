import PhotosIcon from '@/images/icons/photos.svg';
import DropzoneThumbnail from '@/admin/components/form/dropzone/DropzoneThumbnail';
import React from 'react';

const DropzoneContent = ({
    getRootProps,
    getInputProps,
    errors,
    files,
    renderModal,
    removeFile,
    dropzoneThumbnailAdditionalActions,
}) => {
    return (
        <section className="container">
            <div
                {...getRootProps({
                    className: `dropzone max-w-full flex flex-col px-4 py-2 justify-center items-center min-h-[130px] border ${errors.message ? 'border-red-500 hover:border-red-700 hover:border-2' : 'border-gray-300 hover:border-primary-stronger'} border-dashed rounded-md cursor-pointer hover:border-primary-stronger hover:scale-[105%] transition-all`,
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
                            <DropzoneThumbnail
                                file={file}
                                renderModal={renderModal}
                                removeFile={removeFile}
                                additionalActions={dropzoneThumbnailAdditionalActions}
                            />
                        </div>
                    ))}
                </div>
            )}
        </section>
    );
};

export default DropzoneContent;
