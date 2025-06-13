import React, { FC } from 'react';
import FormSection from '@admin/common/components/form/FormSection';
import { hasAnyFieldError } from '@admin/common/utils/formUtils';
import FormGroup from '@admin/common/components/form/FormGroup';
import InputLabel from '@admin/common/components/form/input/InputLabel';
import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import Switch from '@admin/common/components/form/input/Switch';
import { DynamicFields } from '@admin/common/components/form/DynamicFields';
import CurrencyIcon from '@/images/icons/currency.svg';
import { useAppData } from '@admin/common/context/AppDataContext';
import SingleImageUploader from '@admin/common/components/form/SingleImageUploader';
import { Control, FieldErrors, Path, UseFormRegister, UseFormSetValue, useWatch } from 'react-hook-form';
import { CarrierFormData } from '@admin/modules/carrier/interfaces/CarrierFormData';

interface CarrierFormBodyProps {
    register: UseFormRegister<CarrierFormData>;
    setValue: UseFormSetValue<CarrierFormData>;
    fieldErrors: FieldErrors<CarrierFormData>;
    formData: CarrierFormData;
    control: Control<CarrierFormData>;
}

const CarrierFormBody: FC<CarrierFormBodyProps> = ({ register, fieldErrors, setValue, formData, control }) => {
    const { currency } = useAppData();

    const isExternal = useWatch({
        control,
        name: 'isExternal',
    });

    return (
        <FormSection title="Informacje" forceOpen={hasAnyFieldError(fieldErrors, ['name'])}>
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

            <FormGroup label={<InputLabel label="Aktywny?" />}>
                <Switch {...register('isActive')} />
            </FormGroup>

            <FormGroup label={<InputLabel label="Zintegrowany przewoźnik (API)?" />}>
                <Switch {...register('isExternal')} />
            </FormGroup>

            {isExternal && (
                <FormSection
                    title="Informacje dla zintegrowanego przewoźnika"
                    useToggleContent={false}
                    forceOpen={hasAnyFieldError(fieldErrors, ['externalData'])}
                >
                    <DynamicFields
                        name="externalData"
                        control={control}
                        renderItem={(index, namePrefix) => (
                            <div className="space-y-2 flex flex-col gap-4">
                                <FormGroup label={<InputLabel isRequired={true} label="Nazwa" />}>
                                    <InputField
                                        {...register(`${namePrefix}.key` as Path<CarrierFormData>, {
                                            ...validationRules.required(),
                                        })}
                                        placeholder="Klucz konfiguracji"
                                        type="text"
                                        hasError={!!fieldErrors?.externalData?.[index]?.key}
                                        errorMessage={fieldErrors?.externalData?.[index]?.key?.message}
                                    />
                                </FormGroup>
                                <FormGroup label={<InputLabel isRequired={true} label="Wartość" />}>
                                    <InputField
                                        {...register(`${namePrefix}.value` as Path<CarrierFormData>, {
                                            ...validationRules.required(),
                                        })}
                                        placeholder="Wartość konfiguracji"
                                        type="text"
                                        hasError={!!fieldErrors?.externalData?.[index]?.value}
                                        errorMessage={fieldErrors?.externalData?.[index]?.value?.message}
                                    />
                                </FormGroup>
                            </div>
                        )}
                    />
                </FormSection>
            )}
        </FormSection>
    );
};

export default CarrierFormBody;
