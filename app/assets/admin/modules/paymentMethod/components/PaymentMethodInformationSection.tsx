import FormSection from '@admin/common/components/form/FormSection';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import Description from '@admin/common/components/Description';
import CurrencyIcon from '@/images/icons/currency.svg';
import Switch from '@admin/common/components/form/input/Switch';
import React, { FC } from 'react';
import { useAppData } from '@admin/common/context/AppDataContext';
import { FieldErrors, UseFormRegister, UseFormSetValue } from 'react-hook-form';
import { PaymentMethodFormData } from '@admin/modules/paymentMethod/interfaces/PaymentMethodFormData';
import SingleImageUploader from '@admin/common/components/form/SingleImageUploader';
import GenericTextField from '@admin/common/components/form/fields/formGroup/GenericTextField';
import FormSwitchField from '@admin/common/components/form/fields/formGroup/FormSwitchField';

interface PaymentMethodInformationSectionProps {
    register: UseFormRegister<PaymentMethodFormData>;
    fieldErrors: FieldErrors<PaymentMethodFormData>;
    setValue: UseFormSetValue<PaymentMethodFormData>;
    formData: PaymentMethodFormData;
}

const PaymentMethodInformationSection: FC<PaymentMethodInformationSectionProps> = ({
    register,
    fieldErrors,
    setValue,
    formData,
}) => {
    const { currency } = useAppData();

    return (
        <FormSection title="Informacje" useToggleContent={false}>
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
                label="Nazwa widoczna na stronie"
                placeholder="Płatność przy odbiorze"
            />
            <GenericTextField
                register={register}
                fieldErrors={fieldErrors}
                fieldName="code"
                label="Nazwa widoczna tylko w panelu"
                placeholder="Płatność odbierana przez pracownika"
                description="Unikatowa nazwa widoczna tylko w panelu."
            />

            <FormGroup label={<InputLabel isRequired={true} label="Prowizja" htmlFor="fee" />}>
                <InputField
                    type="text"
                    id="fee"
                    hasError={!!fieldErrors?.fee}
                    errorMessage={fieldErrors?.fee?.message}
                    icon={<CurrencyIcon className="text-gray-500 w-[16px] h-[16px]" />}
                    {...register('fee', {
                        ...validationRules.required(),
                        ...validationRules.numeric(currency?.roundingPrecision),
                    })}
                />
            </FormGroup>

            <FormSwitchField register={register} name={'isActive'} fieldErrors={fieldErrors} label="Aktywna" />
            <FormSwitchField register={register} name={'isRequireWebhook'} fieldErrors={fieldErrors} label="Czy wymagany jest webhook (API)" />
        </FormSection>
    );
};

export default PaymentMethodInformationSection;
