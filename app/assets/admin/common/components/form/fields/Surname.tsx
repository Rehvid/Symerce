import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import React from 'react';
import { FieldErrors, FieldValues, Path, UseFormRegister } from 'react-hook-form';

export interface SurnameField {
    surname?: string | null;
}

interface SurnameProps<T extends FieldValues> {
    register: UseFormRegister<T>;
    fieldErrors: FieldErrors<T>;
}

const Surname = <T extends FieldValues>({
    register,
    fieldErrors,
}: SurnameProps<T>) => (
    <InputField
        type="text"
        id="surname"
        hasError={!!fieldErrors?.surname}
        errorMessage={fieldErrors?.surname?.message as string | undefined}
        icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
        {...register('surname' as Path<T>, {
            ...validationRules.required(),
            ...validationRules.minLength(2),
        })}
    />
);

export default Surname;
