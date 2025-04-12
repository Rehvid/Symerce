import React, { useState } from 'react';
import AppSwitch from '@/admin/components/form/AppSwitch';
import AppFormSideColumn from '@/admin/components/form/AppFormSideColumn';
import Dropzone from '@/admin/components/form/dropzone/Dropzone';
import { Controller } from 'react-hook-form';
import ModalHeader from '@/admin/components/modal/ModalHeader';
import ModalBody from '@/admin/components/modal/ModalBody';

const CategoryFormSideColumn = ({ register, control, categoryFormData, setCategoryFormData }) => {
    const [images, setImages] = useState(categoryFormData.image == null ? [] : [{ ...categoryFormData.image }]);

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
        <div className="flex flex-col h-full gap-4">
            <AppFormSideColumn sectionTitle="Zdjęcia">
                <Controller
                    name="image"
                    control={control}
                    defaultValue={[]}
                    render={({ field }) => (
                        <Dropzone
                            onChange={field.onChange}
                            renderModal={renderModal}
                            value={images}
                            setValue={(newImages) => {
                                setImages(newImages);
                                setCategoryFormData((prev) => ({
                                    ...prev,
                                    image: newImages.length > 0 ? newImages[0] : null,
                                }));
                            }}
                        />
                    )}
                />
            </AppFormSideColumn>
            <AppFormSideColumn sectionTitle="Attribute">
                <AppSwitch label="Aktywny" {...register('isActive')} />
            </AppFormSideColumn>
        </div>
    );
};
export default CategoryFormSideColumn;
