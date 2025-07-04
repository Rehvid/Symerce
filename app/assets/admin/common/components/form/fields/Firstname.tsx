import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import React from 'react';
import { FieldErrors, FieldValues, Path, UseFormRegister } from 'react-hook-form';

export interface FirstnameField {
    firstname?: string | null;
}

interface FirstnameProps<T extends FieldValues> {
    register: UseFormRegister<T>;
    fieldErrors: FieldErrors<T>;
}

const Firstname = <T extends FieldValues>({
register,
fieldErrors,
}: FirstnameProps<T>) => (
    <InputField
        type="text"
        id="firstname"
        hasError={!!fieldErrors?.firstname}
        errorMessage={fieldErrors?.firstname?.message as string | undefined}
        icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
        {...register('firstname' as Path<T>, {
            ...validationRules.required(),
            ...validationRules.minLength(2),
        })}
    />
);

export default Firstname;
