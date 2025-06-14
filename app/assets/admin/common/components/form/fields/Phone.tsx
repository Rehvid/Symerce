import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import React from 'react';
import { FieldErrors, FieldValues, Path, UseFormRegister } from 'react-hook-form';
import { createConditionalValidator } from '@admin/common/utils/formUtils';

interface PhoneProps<T extends FieldValues> {
    register: UseFormRegister<T>;
    fieldErrors: FieldErrors<T>;
    isRequired: boolean;
}

const Phone = <T extends FieldValues>({ register, fieldErrors, isRequired = false }: PhoneProps<T>) => (
        <>
            {isRequired ? (
                <InputField
                    type="text"
                    id="phone"
                    hasError={!!fieldErrors?.phone}
                    errorMessage={fieldErrors?.phone?.message as string | undefined}
                    icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
                    {...register('phone' as Path<T>, {
                        ...validationRules.required(),
                        ...validationRules.phone(),
                    })}
                />
            ) : (
                <InputField
                    type="text"
                    id="phone"
                    hasError={!!fieldErrors?.phone}
                    errorMessage={fieldErrors?.phone?.message as string | undefined}
                    icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
                    {...register('phone' as Path<T>, {
                        validate: createConditionalValidator(
                            validationRules.phone()
                        ),
                    })}
                />
            )}
        </>
);

export default Phone;
