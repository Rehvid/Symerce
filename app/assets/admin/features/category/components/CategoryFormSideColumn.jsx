import React from 'react';
import AppSwitch from '@/admin/components/form/AppSwitch';
import AppFormSideColumn from '@/admin/components/form/AppFormSideColumn';
import AppDropzone from '@/admin/components/form/dropzone/AppDropzone';
import { Controller } from 'react-hook-form';
import ModalHeader from '@/admin/components/modal/ModalHeader';
import ModalBody from '@/admin/components/modal/ModalBody';

const CategoryFormSideColumn = ({ register, control }) => {
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
                    defaultValue=""
                    render={({ field }) => (
                        <AppDropzone value={field.value} onChange={field.onChange} renderModal={renderModal} />
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
