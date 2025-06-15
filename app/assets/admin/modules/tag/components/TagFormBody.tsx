import FormSection from '@admin/common/components/form/FormSection';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import React, { FC } from 'react';
import Chrome from '@uiw/react-color-chrome';
import { Control, Controller, FieldErrors, UseFormRegister } from 'react-hook-form';
import { TagFormData } from '@admin/modules/tag/interfaces/TagFormData';
import GenericTextField from '@admin/common/components/form/fields/formGroup/GenericTextField';
import FormSwitchField from '@admin/common/components/form/fields/formGroup/FormSwitchField';

interface TagFormBodyProps {
    register: UseFormRegister<TagFormData>;
    fieldErrors: FieldErrors<TagFormData>;
    control: Control<TagFormData>;
}
const TagFormBody: FC<TagFormBodyProps> = ({ register, fieldErrors, control }) => {
    return (
        <FormSection title="Informacje" useToggleContent={false}>
            <GenericTextField register={register} fieldErrors={fieldErrors} fieldName="name" label="Nazwa" isRequired={true} />
            <FormGroup label={<InputLabel label="Kolor tła" htmlFor="backgroundColor" />}>
                <Controller
                    name="backgroundColor"
                    control={control}
                    render={({ field }) => (
                        <Chrome color={field.value} onChange={(color) => field.onChange(color.hexa)} />
                    )}
                />
            </FormGroup>

            <FormGroup label={<InputLabel label="Kolor textu" htmlFor="textColor" />}>
                <Controller
                    name="textColor"
                    control={control}
                    render={({ field }) => (
                        <Chrome color={field.value} onChange={(color) => field.onChange(color.hexa)} />
                    )}
                />
            </FormGroup>

            <FormSwitchField register={register} name="isActive" label="Tag widoczny na stronie?" />
        </FormSection>
    );
};

export default TagFormBody;
