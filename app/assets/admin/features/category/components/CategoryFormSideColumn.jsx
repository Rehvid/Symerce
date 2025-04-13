import React, { useEffect } from 'react';
import AppSwitch from '@/admin/components/form/AppSwitch';
import AppFormSideColumn from '@/admin/components/form/AppFormSideColumn';
import Dropzone from '@/admin/components/form/dropzone/Dropzone';
import ModalHeader from '@/admin/components/modal/ModalHeader';
import ModalBody from '@/admin/components/modal/ModalBody';
import { useDropzoneLogic } from '@/admin/hooks/useDropzoneLogic';
import { normalizeFiles } from '@/admin/utils/helper';
import DropzonePreviewActions from '@/admin/components/form/dropzone/DropzonePreviewActions';

const CategoryFormSideColumn = ({ register, categoryFormData, setCategoryFormData, setValue }) => {
    const categoryFormDataImage = normalizeFiles(categoryFormData?.image);

    const setDropzoneValue = (image) => {
        setValue('image', image);
        setCategoryFormData((prevFormData) => ({
            ...prevFormData,
            image: image
        }));
    };

    const { onDrop, errors, removeFile } = useDropzoneLogic(setDropzoneValue, categoryFormDataImage);

    const renderModal = (file) => (
        <>
            <ModalHeader title={file.name} />
            <ModalBody>
                <div>
                    <img src={file.preview} alt={file.name} />
                </div>
            </ModalBody>
        </>
    );

    return (
        <div className="flex flex-col h-full gap-[2.5rem]">
            <AppFormSideColumn sectionTitle="Zdjęcie">
                <Dropzone
                  onDrop={onDrop}
                  errors={errors}
                  containerClasses="relative"
                >
                    {categoryFormDataImage.length > 0 && (
                            categoryFormDataImage.map((file, key) => (
                              <div className="absolute flex top-0 h-full w-full rounded-lg" key={key}>
                                <img
                                  className="rounded-lg mx-auto object-cover w-full"
                                  src={file.preview}
                                  alt={file.name}
                                />
                                <div className="absolute rounded-lg transition-all w-full h-full inset-0 flex items-center justify-center gap-3 hover:backdrop-blur-xl">
                                  <DropzonePreviewActions
                                    renderModal={renderModal}
                                    removeFile={removeFile}
                                    file={file}
                                  />
                                </div>
                              </div>
                            ))
                    )}
                </Dropzone>
            </AppFormSideColumn>
            <AppFormSideColumn sectionTitle="Atrybuty">
                <AppSwitch label="Aktywny?" {...register('isActive')} />
            </AppFormSideColumn>
        </div>
    );
};
export default CategoryFormSideColumn;
