import InputField from '@admin/common/components/form/input/InputField';
import LabelNameIcon from '@/images/icons/label-name.svg';
import { validationRules } from '@admin/common/utils/validationRules';
import React  from 'react';
import { FieldErrors, FieldValues, Path, UseFormRegister } from 'react-hook-form';
import { createConditionalValidator } from '@admin/common/utils/formUtils';

export interface EmailField {
    email?: string | null;
}

interface EmailProps <T extends FieldValues> {
    register: UseFormRegister<T>;
    fieldErrors: FieldErrors<T>;
    isRequired: boolean;
}


const Email = <T extends FieldValues>({ register, fieldErrors, isRequired }: EmailProps<T>) => (
    <>
        {isRequired ? (
            <InputField
                type="text"
                id="email"
                hasError={!!fieldErrors?.email}
                errorMessage={fieldErrors?.email?.message as string | undefined}
                icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
                {...register('email' as Path<T>, {
                    ...validationRules.required(),
                    ...validationRules.email(),
                    ...validationRules.minLength(2),
                    ...validationRules.maxLength(255)
                })}
            />
        ) : (
            <InputField
                type="text"
                id="email"
                hasError={!!fieldErrors?.email}
                errorMessage={fieldErrors?.email?.message as string | undefined}
                icon={<LabelNameIcon className="text-gray-500 w-[16px] h-[16px]" />}
                {...register('email' as Path<T>, {
                    validate: createConditionalValidator(
                        validationRules.minLength(2),
                        validationRules.maxLength(255),
                        validationRules.email(),
                    ),
                })}
            />
        )}
    </>
)

export default Email;
