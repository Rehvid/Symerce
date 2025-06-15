import FormSection from '@admin/common/components/form/FormSection';
import { hasAnyFieldError } from '@admin/common/utils/formUtils';
import React, { FC } from 'react';
import { BrandFormData } from '@admin/modules/brand/interfaces/BrandFormData';
import { FieldErrors, UseFormRegister, UseFormSetValue } from 'react-hook-form';
import SingleImageUploader from '@admin/common/components/form/SingleImageUploader';
import GenericTextField from '@admin/common/components/form/fields/formGroup/GenericTextField';
import FormSwitchField from '@admin/common/components/form/fields/formGroup/FormSwitchField';

interface BrandFormBodyProps {
    formData: BrandFormData;
    register: UseFormRegister<BrandFormData>;
    setValue: UseFormSetValue<BrandFormData>;
    fieldErrors: FieldErrors<BrandFormData>;
}

const BrandFormBody: FC<BrandFormBodyProps> = ({ register, fieldErrors, setValue, formData }) => {
    return (
        <FormSection title="Informacje" forceOpen={hasAnyFieldError(fieldErrors, ['name'])} useToggleContent={false}>
            <SingleImageUploader
                label="Miniaturka"
                fieldName="thumbnail"
                setValue={setValue}
                initialValue={formData?.thumbnail}
            />
            <GenericTextField
                register={register}
                fieldErrors={fieldErrors}
                fieldName="name"
                label="Nazwa marki"
            />

            <FormSwitchField register={register} name="isActive" label="Aktywny" />
        </FormSection>
    );
};

export default BrandFormBody;
