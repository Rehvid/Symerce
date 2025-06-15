import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { FieldErrors, FieldValues, Path, UseFormRegister } from 'react-hook-form';
import { validationRules } from '@admin/common/utils/validationRules';
import React from 'react';

export interface StreetField {
    street?: string | null;
}

interface StreetProps<T extends FieldValues> {
    register: UseFormRegister<T>;
    fieldErrors: FieldErrors<T>;
    fieldName?: keyof T;
}

const Street = <T extends Record<string, any>>({
   register,
   fieldErrors,
   fieldName = 'street',
}: StreetProps<T>) => (
    <InputField
        type="text"
        id={String(fieldName)}
        hasError={!!fieldErrors?.[fieldName]}
        errorMessage={fieldErrors?.[fieldName]?.message as string | undefined}
        icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
        {...register(fieldName as Path<T>, {
            ...validationRules.required(),
            ...validationRules.minLength(2),
        })}
    />
);

export default Street;
