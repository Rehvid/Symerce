import FormSection from '@admin/common/components/form/FormSection';
import { hasAnyFieldError } from '@admin/common/utils/formUtils';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import Switch from '@admin/common/components/form/input/Switch';
import React, { FC } from 'react';
import { BrandFormData } from '@admin/modules/brand/interfaces/BrandFormData';
import { FieldErrors, UseFormRegister, UseFormSetValue } from 'react-hook-form';
import SingleImageUploader from '@admin/common/components/form/SingleImageUploader';

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
            <FormGroup label={<InputLabel isRequired={true} label="Nazwa" htmlFor="name" />}>
                <InputField
                    type="text"
                    id="name"
                    hasError={!!fieldErrors?.name}
                    errorMessage={fieldErrors?.name?.message}
                    icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
                    {...register('name', {
                        ...validationRules.required(),
                        ...validationRules.minLength(2),
                    })}
                />
            </FormGroup>

            <FormGroup label={<InputLabel label="Aktywny?" />}>
                <Switch {...register('isActive')} />
            </FormGroup>
        </FormSection>
    );
};

export default BrandFormBody;
